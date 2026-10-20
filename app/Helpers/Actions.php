<?php


namespace App\Helpers;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class Actions
{
    public static function Save(Request $request, Model $model, $fields = array(), $id = null, $id_name = 'id', $primary_key = 'id', $returnBack = true){
        $updateOrCreate = null;
        try {

            if ($model->isFillable('created_by')){
                $fields['created_by'] = auth()->id();
            }

            if ($model->isFillable('updated_by')){
                $fields['updated_by'] = auth()->id();
            }

            $updateOrCreate = $model::updateOrCreate(array($id_name => $id), $fields);


        } catch (\Exception $e) {
            if(\request()->ajax()){
                return response()->json(array(
                    'error' => $e->getMessage()
                ));
            }
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        } finally {

            $code = "";
            if($request->get("code"))
                $code = '?code='.$request->get("code");

            if($updateOrCreate) {

                if($request->route()->getActionMethod() == 'store'){
                    log_add(\request()->get($primary_key) . ' kayıt eklendi');
                    if(\request()->ajax()){
                        return response()->json(array(
                            'success' => 'Başarılı: Kayıt başarıyla eklendi!',
                            'data' => $updateOrCreate,
                        ));
                    }

                    if ($returnBack)
                        return redirect()->to(_route('index').$code)->with('success', 'Başarılı: Kayıt başarıyla eklendi!');
                    else
                        return redirect()->back()->with('success', 'Başarılı: Kayıt başarıyla eklendi!');
                }else{
                    log_add(\request()->get($primary_key) . ' kayıt güncellendi');
                    if(\request()->ajax()){
                        return response()->json(array(
                            'success' => 'Başarılı: Kayıt başarıyla güncellendi!',
                            'data' => $updateOrCreate,
                        ));
                    }

                    if ($returnBack)
                        return redirect()->to(_route('index').$code)->with('success', 'Başarılı: Kayıt başarıyla güncellendi!');
                    else
                        return redirect()->back()->with('success', 'Başarılı: Kayıt başarıyla güncellendi!');
                }
            }
        }
    }

    public static function RemoveBack($model, $primary_key){

        $update = null;
        try {
            $update = $model::withTrashed()->find(\request()->get('id'));
            $update->deleted_at = null;
            if(isset($update->updated_by)){
                $update->updated_by = auth()->id();
            }

            $update->save();
        }catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }finally{
            if($update){
                log_add($update->$primary_key . ' kayıt silme işlemi geri alındı');
                return redirect()->to(_route('index'))->with('success', 'Başarılı: Kayıt başarıyla geri alındı!');
            }
        }
    }

    public static function Remove($model, $primary_key){
        $update = null;
        try {
            $update = $model::find(\request()->get('id'));
            $update->deleted_at = date("Y-m-d");
            $update->updated_at = date("Y-m-d");
            if(isset($update->updated_by)) {
                $update->updated_by = auth()->id();
            }
            $update->save();
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        } finally {
            if($update){
                log_add($update->$primary_key . ' kayıt silindi.');
                if(\request()->ajax()){
                    return response()->json(array(
                        'success' => 'Başarılı: Kayıtlar başarıyla silindi!',
                        'data' => $update
                    ));
                }
                return redirect()->to(_route('index'))->with('success', 'Başarılı: Kayıt başarıyla geri alındı!');
            }
        }
    }

    public static function StatusSave(Request $request, $model, $primary_key){

        $update = null;
        try {
            $update = $model::find($request->get('id'));
            $update->status = $request->get('status');
            if(isset($update->updated_by)){
                $update->updated_by = auth()->id();
            }

            $update->save();
        }catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }finally{
            if($update){
                log_add($update->$primary_key . ' kayıt güncellendi');
                return redirect()->to(_route('index'))->with('success', 'Başarılı: Kayıt başarıyla güncellendi!');
            }
        }
    }

    public static function sort_order(Request $request, $model, $primary_key, $id_name=null){
        $errors = array();
        $ids = array_filter(explode(',', request()->get('id')));

        try{
            $index = 1;
            foreach ($ids as $id) {
                try{
                    if($id_name)
                        $update = $model::where($id_name, $id)->first();
                    else
                        $update = $model::find($id);
                    $update->sort_order = $index;
                    $update->save();
                    log_add($update->$primary_key . ' kayıt sıralaması güncellendi');
                    $index++;

                } catch (\Exception $e) {
                    $errors[] = $e->getMessage();
                }
            }
        }catch (\Exception $e) {
            $errors[] = $e->getMessage();
        }

        if(count($errors)){
            return response()->json([
                'error' => $errors
            ]);
        } else{
            if(\request()->ajax()){
                return response()->json(array(
                    'success' => 'Başarılı: Kayıt başarıyla güncellendi!',
                    'redirect' => true
                ));
            } else {
                return response()->json([
                    'redirect' => true
                ]);
            }
        }

    }

    public static function destroy($model, $primary_key)
    {
        $ids = explode(',', \request()->get('id'));
        return self::destroy_ids($model, $primary_key, $ids);
    }

    public static function destroy_ids($model, $primary_key, $ids){
        $deletes = array();
        $order = 0;

        try {
            foreach ($ids as $id) {
                if(is_numeric($id)) {
                    $id_n = $model::find($id);
                } else {
                    $id_n = $model::where("token", $id)->first();
                }

                if(!empty($id_n->order_id)) {
                    $order = $id_n->order_id;
                }

                if($id_n){
                    $key = $id_n->getKeyName();

                    if($model::destroy($id_n->$key)){
                        $deletes[] = $id_n->$primary_key;
                        if (\request()->get('old_path'))
                            File::delete(\request()->get('old_path'));
                    }
                } else {
                    if(\request()->ajax()){
                        return response()->json(array(
                            'error' => 'Kayıt bulunamadı'
                        ));
                    }else{
                        return redirect()->back()->withInput()->withErrors('error', 'Kayıt bulunamadı');
                    }
                    break;
                }

            }

            if(count($deletes) > 1){
                log_add(implode(', ', $deletes) . ' kayıtlar silindi');
                if(\request()->ajax()){
                    if(\request()->ajax()){
                        return response()->json(array(
                            'success' => 'Başarılı: Kayıtlar başarıyla silindi!',
                            'data' => implode(', ', $deletes)
                        ));
                    }
                }
                return redirect()->to(_route('index'))->with('success', 'Başarılı: Kayıtlar başarıyla silindi!');
            } else {
                log_add(implode(', ', $deletes) . ' kayıt silindi');

                if(\request()->ajax()){
                    return response()->json(array(
                        'success' => 'Başarılı: Kayıt başarıyla silindi!',
                        'data' => implode(', ', $deletes),
                        'id_n' => $id_n,
                    ));
                }
                return redirect()->to(_route('index'))->with('success', 'Başarılı: Kayıt başarıyla silindi!');
            }

        }catch (\Exception $e) {
            if(\request()->ajax()){
                return response()->json(array(
                    'error' => $e->getMessage()
                ));
            }else{
                return redirect()->back()->withInput()->withErrors('error', $e->getMessage());
            }

        }
    }
}

<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Panel\User;
use App\Rules\UserGroupRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    protected $model = User::class;
    public function index(){
        return view('panel.profile');
    }

    public function update(Request $request, $id) {
        $this->Validation($request, $id);

        try {
            $except = array('password_confirmation');
            if($request->input('password')){
                $request['password'] = Hash::make($request->input('password'));
            } else {
                $except = ['password', 'password_confirmation'];
            }

            $except = array_merge($except, array('_token', '_method'));
            $model = $this->model::find($id);

            if ($model) {
                if ($request->get("image"))
                    $request["image"] = str_replace(config("app.url"), "", $request->get("image"));

                $model->fill(request()->except($except));
                $model->save();
                return redirect()->to(route("profile.index"))->with(['success' => "Profil bilgisi güncellendi."]);
            }

        } catch (\Exception $e) {
            return redirect()->to(route("profile.index"))->with(['error' => "İşlem yapılırken hata oluştu. Hata: " . $e->getMessage()]);
        }
    }

    protected function Validation(Request $request, $id = null){

        $attributes = [
            'name'                  => "Ad Soyad",
            'email'                 => "E-Posta",
            'password'              => "Şifre",
            'password_confirmation' => "Şifre Tekrar",
        ];

        $rules = [
            'name'          => 'required|min:3|max:255',
            'email'         => ['required', 'email', Rule::unique('users')->ignore($id)],
            'user_group_id' => [new UserGroupRule($id)],
        ];

        if($request->input('password') || $request->getMethod() == 'POST'){
            $rules['password'] = ['required', 'confirmed', Password::min(8)];
        }

        $request->validate($rules, [], $attributes);

    }
}

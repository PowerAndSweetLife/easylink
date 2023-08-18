<?php

namespace App\Http\Controllers\Client;

use App\Helper\Code;
use App\Helper\FileManager;
use App\Helper\Session;
use App\Http\Controllers\Controller;
use App\Http\Requests\ClientEntrepriseRequest;
use App\Http\Requests\ClientParticulierRequest;
use App\Mail\ClientMail;
use App\Models\Client;
use App\Models\Metadata;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    public function __construct()
    {
        App::setLocale('fr');
    }

    public function index(string $type)
    {
        $view = "client.register-company";
        if($type === 'particulier')
        {
            $view = "client.register-particulier";
        }
        
        if(in_array(env('APP_ENV'), ['local', 'dev']))
        {
            return $this->_withFake($view, $type);   
        }
        return view($view , [
            'active' => $type
        ]);
    }

    public function particulier(ClientParticulierRequest $request)
    {
        $info = $request->validated();
        if($info['password'] !== $info['confirm-password'])
        {
            return redirect(route('client.register', ['type' => 'particulier']))->withInput()->withErrors([
                'password' => __('The two passwords are different'),
                'confirm-password' => __('The two passwords are different')
            ]);
        }
        unset($info['confirm-password']);
        $client = new Client($info);
        $client->password = Hash::make($info['password']);
        $client->uid = $this->_generateUid();
        $client->email_confirmation_code = Code::generateConfirmation();
        $client->type = 'individual';
        
        $client->save();

        /**
         * Envoie d'email
         */
        $this->_sendConfirmationCode($client);

        Session::setUserdata($request, $client);
        return to_route('client.index');

    }
    public function entreprise(ClientEntrepriseRequest $request)
    {
        $info = $request->validated();
        if($info['password'] !== $info['confirm-password'])
        {
            return redirect(route('client.register', ['type' => 'particulier']))->withInput()->withErrors([
                'password' => __('The two passwords are different'),
                'confirm-password' => __('The two passwords are different')
            ]);
        }
        unset($info['confirm-password']);
        $client = new Client($info);
        $client->password = Hash::make($info['password']);
        $client->uid = $this->_generateUid();
        $client->email_confirmation_code = Code::generateConfirmation();
        $client->type = 'company';
        
        /** @var UploadedFile */        
        $file = $request->file('cif');
        if($file !== null)
        {
            $filename = FileManager::generateFilename($file, 'cif');
            $file->storeAs('cif', $filename);
            $client->cif_card = $filename;
        }

        $client->save();

        /**
         * Envoie d'email
         */
        $this->_sendConfirmationCode($client);

        Session::setUserdata($request, $client);
        return to_route('client.index');
    }

    private function _generateUid(): string
    {
        $currentMatricule = Metadata::where('key', date('Y') . '_last_uid')->get()->first();
        $newMatriculeIndex = null;
        if(is_null($currentMatricule))
        {
            $newMatriculeIndex = 1;
            $metadata = new Metadata([
                'key' => date('Y') . '_last_uid',
                'value' => 1
            ]);
            $metadata->save();
        }
        else
        {
            $newMatriculeIndex = (int)$currentMatricule->value + 1;
            $currentMatricule->value = $newMatriculeIndex;
            $currentMatricule->save();
        }

        return "MG" . date('y') . str_pad($newMatriculeIndex, 3, "0", STR_PAD_LEFT);
    }
        
    /**
     * Renvoi la vue register avec des faux donnée | En mode dev uniquement
     *
     * @param  string $view
     * @param  string $type
     */
    private function _withFake(string $view, string $type)
    {
        $data = [
            "email" => fake()->email(),
            "contact" => fake()->phoneNumber(),
            "password" => "1234",
        ];
        if($type === 'entreprise')
        {
            $data["company_name"] = fake()->company();
            $data["nif"] = fake()->randomNumber(8, true);
            $data["stat"] = fake()->randomNumber(8, true);
            $data["rcs"] = fake()->randomNumber(8, true);
        }
        else
        {
            $civility = "male";
            if(rand(1, 10) % 2) {
                $civility = "female";
            }
            $data['civility'] = $civility === 'male' ? 'Mr.' : 'Ms.';
            $data['firstname'] = fake()->firstName($civility);
            $data['lastname'] = fake()->lastName($civility);
        }
        $client = new Client($data);
        return view($view , [
            'active' => $type,
            'client' => $client
        ]); 
    }

    private function _sendConfirmationCode(Client $client)
    {
       Mail::send(new ClientMail($client));
    }

}

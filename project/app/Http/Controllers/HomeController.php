<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\File;
use App\Mail\TestMail;

class HomeController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function sendMail(Request $request) {
        $data = $request -> validate([
            'mailText' => 'required|min:5'
        ]);
		//la inviamo all'user collegato
        Mail::to(Auth::user() -> email)
		//$data['StringaPassataNelForm']
            -> send(new TestMail($data['mailText'])); 
        return redirect() -> back();
    }
    
    public function index()
    {
        return view('home'); 
    }

    public function updateUserIcon(Request $request) {

        //validazione
        $request -> validate([
            'icon' => 'required|file'
        ]);
        $image = $request -> file('icon');

        //evita l'accumulamento delle img
        $this -> deleteUserIcon();

    //ALGORITMO PER RISOLVERE IL CONFLITTO DEI NOMI DEI FILE
        //ricaviamo l'estensione del file caricato    
        $ext = $image -> getClientOriginalExtension();
        //creiamo il nome del file updato, formato da un n. random da n. a m. + tempo in millisecondi
        $name = rand(100000, 999999) . '_' . time();
        //nome file completo
        $destFile = $name . '.' . $ext;
        
        $file = $image -> storeAs('icon', $destFile, 'public');

    //SALVIAMO L'INFORMAZIONE NEL DB
        $user = Auth::user();
        //il valore della colonna icon sarà uguale al file
        $user -> icon = $destFile;
        $user -> save();

        return redirect() -> back();
    }

    public function clearUserIcon() {

        //evita l'accumulamento delle img
        $this -> deleteUserIcon();

        //recupero lo user
        $user = Auth::user();
        //tolgo il valore icon e metto NULL
        $user -> icon = null;
        //vado a salvare
        $user -> save();

        return redirect() -> back();
    }

    //funzione da inserire nell'update e nel clear, che evita l'accumulamento delle img, cancellando la precedente caricata prima di inserirne una nuova
    private function deleteUserIcon() {
        
        //recupero lo user e la sua icona
        $user = Auth::user();

        //prova ad eseguire queste cose
        try {
            
            //nome del file da eliminare
            $fileName = $user -> icon;
            
            //percorso file da eliminare
            $file = storage_path('app/public/icon/'.$fileName);
    
            $res = File::delete($file);
        //se avviene qualunque errore, non fare nulla
        } catch (\Exception $e) { } //do nothing
    }
}

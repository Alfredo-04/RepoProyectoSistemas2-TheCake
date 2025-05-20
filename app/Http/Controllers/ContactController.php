<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormSubmitted;

class ContactController extends Controller
{
    public function submit(Request $request)
    {
        // Validación de los datos del formulario
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'rating' => 'required|in:1,2,3,4',
            'message' => 'required|string|max:2000',
        ]);

        // Aquí puedes procesar los datos como prefieras:
        // - Guardar en base de datos
        // - Enviar por email
        // - etc.
        
        // Ejemplo de envío de email:
        Mail::to('marce_laime@hotmail.com')->send(new ContactFormSubmitted($validatedData));

        // Redireccionar con mensaje de éxito
        return redirect()->route('contact')->with('success', '¡Gracias por tu mensaje! Nos pondremos en contacto contigo pronto.');
    }
}
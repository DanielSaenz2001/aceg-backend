@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => 'https://www.facebook.com/EscuelaGastronomicaAntonioCardenaz'])
            <img src="https://aceg.edu.pe/assets/logo-fondo/logo.png" alt="Escuela Gastronómica Antonio Cardenaz">
        @endcomponent
    @endslot
    {{-- Body --}}
    # Solicitud para Cambiar de contraseña

    Tengo un Buen día, {{ $user->nombres }} {{ $user->apellido_paterno }} {{ $user->apellido_materno }} con el correo {{ $user->email }} y cuyo DNI es  {{ $user->dni }}, ha solicitado una petición de cambio de contraseña, en este caso presione en el boton para cambiar su contraseña.
@component('mail::button', ['url' => 'https://sistema.aceg.edu.pe/pantallarecuperacion?token='.$token, 'color' => 'primary'])
Recuperar contraseña
@endcomponent

    {{-- Footer --}}
    @slot('footer')
    
        @component('mail::footer')
        Gracias, Soporte Tecnico
            © {{ date('Y') }} ACEG. Todos los derechos reservados: OGx. 
        @endcomponent
    @endslot

@endcomponent
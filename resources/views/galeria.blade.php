@extends("layouts.plantilla")

@section("cabecera")
<h1>Contacto</h1>
@endsection

@section('infoGeneral')

    @if (count($alumnos))

        <table width="50%" border="1">
            @foreach ($alumnos as $alumno)
                <tr>

                    <td>

                        {{$alumno}}

                    </td>
                </tr>
            @endforeach
        </table>

        @else

            {{"Sin alumnos"}}
    @endif

@endsection

@section('pie')
Aqui iria el texto del pie
@endsection
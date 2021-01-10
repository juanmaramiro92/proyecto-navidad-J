<?php

abstract class Dato
{
}

trait Identificable
{
    protected $id;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }
}

class Cliente extends Dato {
    use Identificable;

    private  $email;
    private  $contrasenna;
    private  $codigoCookie;
    private  $nombre;
    private  $telefono;

    public function __construct($id, $email, $contrasenna, $codigoCookie, $nombre, $telefono)
    {
        $this->id = $id;
        $this->setEmail($email);
        $this->setContrasenna($contrasenna);
        $this->setCodigoCookie($codigoCookie);
        $this->setNombre($nombre);
        $this->setTelefono($telefono);

    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getContrasenna()
    {
        return $this->contrasenna;
    }

    public function setContrasenna($contrasenna)
    {
        $this->contrasenna = $contrasenna;
    }

    public function getCodigoCookie()
    {
        return $this->codigoCookie;
    }

    public function setCodigoCookie($codigoCookie)
    {
        $this->codigoCookie = $codigoCookie;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function getTelefono()
    {
        return $this->telefono;
    }

    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
    }

}

class Oferta extends Dato
{
    use Identificable;

    private $puesto;
    private $descripcion;
    private $salario;

    function __construct(int $id=null, string $puesto, string $descripcion, float $salario)
    {
        if        ($id != null && $puesto == null) { // Cargar de BD
            // TODO obtener info de la BD usando el id.
        } else if ($id == null && $puesto != null) { // Crear en BD
           DAO::agregarOferta($puesto,$descripcion,$salario);
        } else { // No hacemos nada con la BD (debe venir todo relleno)
            $this->id = $id;
            $this->puesto = $puesto;
            $this->descripcion = $descripcion;
            $this->salario = $salario;
        }
    }


    public function getPuesto(): string
    {
        return $this->puesto;
    }

    public function setPuesto(string $puesto): void
    {
        $this->puesto = $puesto;
    }

    public function getDescripcion(): string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): void
    {
        $this->descripcion = $descripcion;
    }

    public function getSalario(): float
    {
        return $this->salario;
    }

    public function setSalario(float $salario): void
    {
        $this->salario = $salario;
    }

    public function generarPrecioFormateado(): string
    {
        return number_format ($this->getSalario(), 2) . "€";
    }
}

abstract class ProtoPedido extends Dato
{

    protected $cliente_id;
    protected $lineas;

    public function __construct(int $cliente_id, $lineas)
    {
        $this->cliente_id = $cliente_id;
        $this->lineas = $lineas;
    }

    public function getClienteId(): int
    {
        return $this->cliente_id;
    }

    public function setClienteId(int $cliente_id)
    {
        $this->cliente_id = $cliente_id;
    }

    public function getLineas(): array
    {
        return $this->lineas;
    }

    public function setLineas(array $lineas): void
    {
        $this->lineas = $lineas;
    }


}

class OfertasGuardadas extends ProtoPedido {

    public function __construct(int $cliente_id, $lineas)
    {
        parent::__construct($cliente_id, $lineas);
    }
    public function variarProducto($ofertaId, $variacionUnidades) {
        $nuevaCantidadUnidades = DAO::listadoVariarUnidades($ofertaId, $variacionUnidades);

        $lineas = $this->getLineas();
        $lineaNueva= new LineaCarrito($ofertaId, $nuevaCantidadUnidades);
        array_push($lineas, $lineaNueva);
        $this->setLineas($lineas);
    }
}



abstract class ProtoLinea
{
    protected $oferta_id;
    protected $unidades;

    public function __construct(int $oferta_id, int $unidades)
    {
        $this->oferta_id = $oferta_id;
        $this->unidades = $unidades;
    }

    public function getOfertaId()
    {
        return $this->oferta_id;
    }

    public function setOfertaId($oferta_id)
    {
        $this->oferta_id = $oferta_id;
    }

    public function getUnidades()
    {
        return $this->unidades;
    }

    public function setUnidades($unidades)
    {
        $this->unidades = $unidades;
    }
}

class LineaCarrito extends ProtoLinea
{
    public function __construct(int $oferta_id, int $unidades)
    {
        parent::__construct($oferta_id, $unidades);
    }
}


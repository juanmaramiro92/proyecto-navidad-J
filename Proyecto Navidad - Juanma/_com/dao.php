<?php

require_once "clases.php";
require_once "utilidades.php";

class DAO
{
    private static $pdo = null;

    private static function obtenerPdoConexionBD()
    {
        $servidor = "localhost";
        $identificador = "root";
        $contrasenna = "";
        $bd = "trabajo"; // Schema
        $opciones = [
            PDO::ATTR_EMULATE_PREPARES => false, // Modo emulación desactivado para prepared statements "reales"
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Que los errores salgan como excepciones.
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // El modo de fetch que queremos por defecto.
        ];

        try {
            $pdo = new PDO("mysql:host=$servidor;dbname=$bd;charset=utf8", $identificador, $contrasenna, $opciones);
        } catch (Exception $e) {
            error_log("Error al conectar: " . $e->getMessage());
            exit("Error al conectar" . $e->getMessage());
        }

        return $pdo;
    }

    private static function ejecutarConsulta(string $sql, array $parametros): array
    {
        if (!isset(Self::$pdo)) Self::$pdo = Self::obtenerPdoConexionBd();

        $select = Self::$pdo->prepare($sql);
        $select->execute($parametros);
        return $select->fetchAll();
    }

    private static function ejecutarActualizacion(string $sql, array $parametros): void
    {
        if (!isset(self::$pdo)) self::$pdo = self::obtenerPdoConexionBd();

        $actualizacion = self::$pdo->prepare($sql);
        $actualizacion->execute($parametros);
    }



    /* CLIENTE */

    private static function crearClienteDesdeRs(array $rs): Cliente
    {
        return new Cliente($rs[0]["id"], $rs[0]["email"], $rs[0]["contrasenna"], $rs[0]["codigoCookie"], $rs[0]["nombre"], $rs[0]["telefono"]);
    }

    public static function clienteObtenerPorId(int $id): ?Cliente
    {
        $rs = self::ejecutarConsulta("SELECT * FROM cliente WHERE id=?", [$id]);
        if ($rs) return self::crearClienteDesdeRs($rs);
        else return null;
    }

    public static function clienteObtenerPorEmailYContrasenna($email, $contrasenna): ?Cliente
    {
        $rs = Self::ejecutarConsulta("SELECT * FROM cliente WHERE email=? AND BINARY contrasenna=?",
            [$email, $contrasenna]);
        if ($rs) {
            return self::crearClienteDesdeRs($rs);
        } else {
            return null;
        }
    }

    public static function clienteObtenerPorEmailYCodigoCookie($email, $codigoCookie): ?Cliente
    {
        $rs = self::ejecutarConsulta("SELECT * FROM cliente WHERE email=? AND BINARY codigoCookie=?",
            [$email, $codigoCookie]);
        if ($rs) {
            return self::crearClienteDesdeRs($rs);
        } else {
            return null;
        }
    }
    public static function clienteGuardarCodigoCookie(string $email, string $codigoCookie = null)
    {
        if ($codigoCookie != null)
        {
            self::ejecutarActualizacion("UPDATE cliente SET codigoCookie=? WHERE email=?", [$codigoCookie, $email]);
        } else {
            self::ejecutarActualizacion("UPDATE cliente SET codigoCookie=NULL WHERE email=?", [$email]);
        }

    }

    public static function clienteCrear(string $email, string $contrasenna, string $nombre, string $telefono): void
    {
        self::ejecutarActualizacion("INSERT INTO cliente (email, contrasenna, codigoCookie, nombre, telefono, registrado) VALUES (?,?,NULL,?,?,?,0);",
            [$email, $contrasenna, $nombre, $telefono]);
    }
    public static function clienteActualizar():void
    {
        self::ejecutarActualizacion(
            "UPDATE cliente SET email=\"\*\*\*\*\*\", contrasenna=\"\*\*\*\*\*\", codigoCookie=NULL, nombre=\"\*\*\*\*\*\", telefono=\"\*\*\*\*\*\" WHERE id=?",
            [ $_SESSION["id"]]
        );
        self::pedidoActualizarDireccion($_SESSION["id"]);
    }
    public static function clienteObtenerPorEmail($email):bool
    {
        $rs = self::ejecutarConsulta("SELECT * FROM cliente WHERE email=? ",
            [$email]);
        if ($rs) {
            return true;
        } else {
            return false;
        }
    }



    /* OFERTA */

    public static function ofertaObtenerPorId(int $id)
    {
        $rs = self::ejecutarConsulta("SELECT * FROM oferta WHERE id=?", [$id]);
        $oferta = new Oferta($rs[0]["id"], $rs[0]["puesto"], $rs[0]["descripcion"], $rs[0]["salario"]);
        return $oferta;
    }

    public static function ofertaObtenerTodas(): array
    {
        $datos = [];
        $rs = self::ejecutarConsulta("SELECT * FROM oferta ORDER BY puesto", []);

        foreach ($rs as $fila) {
            $oferta = new Oferta($fila["id"], $fila["puesto"], $fila["descripcion"], $fila["salario"]);
            array_push($datos, $oferta);
        }
        return $datos;
    }

    public static function agregarOferta($puesto, $descripcion, $salario){
        self::ejecutarActualizacion("INSERT INTO oferta (id, puesto, descripcion, salario) VALUES (NULL, ?, ?, ?);",
            [$puesto, $descripcion, $salario]);
    }

    public static function ofertaActualizar(int $id, string $nuevoPuesto, string $nuevaDescripcion, int $nuevoSalario)
    {
        //revisar esta funcion, lo de [id] no me queda claro
        self::ejecutarActualizacion("UPDATE oferta SET puesto = ?, descripcion = ?, salario =? WHERE id=?",
            [$nuevoPuesto, $nuevaDescripcion, $nuevoSalario, $id]);
    }



    /* CARRITO */

    public static function crearListadoOfertasGuardadasCliente(int $clienteId): OfertasGuardadas
    {
        self::ejecutarActualizacion("INSERT INTO pedido (cliente_id) VALUES (?) ", [$clienteId]);
        $carrito = new OfertasGuardadas($clienteId, []);
        return $carrito;
    }

    public static function obtenerListadoOfertasGuardadasId(int $clienteId): int
    {
        $rsPedidoId = self::ejecutarConsulta(
            "SELECT id FROM pedido WHERE cliente_id=?",
            [$clienteId]
        );
        $pedidoID = $rsPedidoId[0]["id"];
        return $pedidoID;
    }

    public static function obtenerListadoOfertasGuardadasParaCliente(int $clienteId)
    {
        $arrayLineasParaCarrito = array();

        $rs = self::ejecutarConsulta("SELECT * FROM linea INNER JOIN pedido ON linea.pedido_id = pedido.id WHERE cliente_id=?", [$clienteId]);
        if (!$rs) {
            return null;
        }
        foreach ($rs as $fila){
            $linea= new LineaCarrito(
                $fila['oferta_id'],
                $fila['unidades']
            );
            array_push($arrayLineasParaCarrito, $linea);
        }
        $carrito = new OfertasGuardadas (
            $rs[0]['cliente_id'],
            $arrayLineasParaCarrito
        );

        return $carrito;
    }

    public static function agregarOfertaListadoOfertasGuardadas(int $clienteId, $ofertaId, $unidades): void
    {
        $pedidoId = self::obtenerListadoOfertasGuardadasId($clienteId);

        self::ejecutarActualizacion(
            "INSERT INTO linea (pedido_id, oferta_id, unidades) VALUES (?,?,?) ",
            [$pedidoId, $ofertaId, $unidades]
        );
    }

    private static function obtenerNumeroOfertasGuardadas($pedidoId, $ofertaId): int
    {
        $rs = self::ejecutarConsulta("SELECT unidades FROM linea WHERE pedido_id=? AND oferta_id=? ",
            [$pedidoId, $ofertaId]);
        if (!$rs) {
            return 0;
        } else {
            return $rs[0]['unidades'];
        }
    }

    public static function listadoUnidades($ofertaId, $nuevaCantidad, $pedidoId): void
    {
        $udsIniciales = self::obtenerNumeroOfertasGuardadas($pedidoId, $ofertaId);
        if ($udsIniciales <= 0) {
            self::ejecutarActualizacion(
                "INSERT INTO linea (pedido_id, oferta_id, unidades) VALUES (?,?,?)",
                [$pedidoId, $ofertaId, $nuevaCantidad]
            );
        }
        else if ($nuevaCantidad<=0){
            self::lineaEliminar($pedidoId, $ofertaId);
        }
        else {
            self::ejecutarActualizacion(
                "UPDATE linea SET unidades=? WHERE pedido_id=? AND oferta_id=?",
                [$nuevaCantidad, $pedidoId, $ofertaId]
            );
        }
    }

    public static function listadoVariarUnidades($clienteId, $ofertaId, $variacionUnidades): int
    {
        $rsPedido = self::ejecutarConsulta("SELECT id FROM pedido WHERE cliente_id=?", [$clienteId]);
        $pedidoId = $rsPedido[0]['id'];
        $unidades = self::obtenerNumeroOfertasGuardadas($pedidoId, $ofertaId);
        if ($unidades==0) {
            $nuevaCantidadUnidades = $variacionUnidades;
        } else {
            $nuevaCantidadUnidades = $variacionUnidades + $unidades;
        }
        if ($variacionUnidades==0){
            self::listadoUnidades($ofertaId, $variacionUnidades, $pedidoId);
            return $variacionUnidades;
        }
        else {
            self::listadoUnidades($ofertaId, $nuevaCantidadUnidades, $pedidoId);
            return $nuevaCantidadUnidades;
        }
    }

    /* LINEA */

    public static function lineaEliminar($pedidoId, $ofertaId)
    {
        self::ejecutarActualizacion(
            "DELETE from linea WHERE pedido_id=? AND oferta_id=?",
            [$pedidoId, $ofertaId]);
    }

}
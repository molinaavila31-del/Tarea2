<?php

use App\Core\Conexion;

class Usuario
{

    private int $id;
    private string $nombre;
    private string $email;
    private string $rol;
    private string $creado_en;

    function __construct(int $id, string $nombre, string $email, string $rol, string $creado_en)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->email = $email;
        $this->rol = $rol;
        $this->creado_en = $creado_en;
    }

    private static function arrayToUsuario(array $row): Usuario
    {
        return new Usuario(
            creado_en: $row['creado_en'],
            rol: $row['rol'],
            email: $row['email'],
            nombre: $row['nombre'] ?? 0,
            id: $row['id']
        );
    }
    public static function listar(): array
    {
        $pdo = null;
        $stmt = null;
        try {
            $pdo = Conexion::getPDOConnection();
            $sql = "SELECT * FROM usuarios";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt = $pdo->query($sql);
            while ($row = $stmt->fetch()) {
                $usuario = self::arrayToUsuario($row);
                $usuarios[] = $usuario;
            }
            //retornar los usuarios
            return $usuarios;
        } catch (PDOException $e) {
            error_log("Error al obtener usuarios: " . $e->getMessage());
            return [];
        } finally {
            $stmt = null;
            $pdo = null;
        }
    }
}

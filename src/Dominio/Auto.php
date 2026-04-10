<?php

namespace App\Dominio;

use App\Core\Conexion;
use PDOException;

class Auto implements \JsonSerializable
{
    private int $id;
    private string $marca;
    private string $modelo;
    private string $patente;
    private string $estado;
    private int $version;

    public function __construct(string $patente, string $marca, string $modelo, string $estado = 'disponible', int $version = 0, ?int $id = null)
    {
        $this->patente = $patente;
        $this->modelo = $modelo;
        $this->estado = $estado;
        $this->version = $version;
        $this->id = $id ?? 0;
        $this->marca = $marca;
    }

    public function reservar(): void
    {
        if ($this->estado !== 'disponible') {
            throw new \Exception("El auto no está disponible.");
        }
        $this->estado = 'reservado';
        $this->version++;
    }

    public function validar(): void
    {
        // Validar patente: 3 letras + 3 dígitos
        if (!preg_match('/^[A-Z]{3}[0-9]{4}$/', $this->patente)) {
            throw new \Exception("Formato de patente inválido. Debe tener 3 letras seguidas de 3 números. Ej: ABC123");
        }

        // Validar estado
        $estadosValidos = ['disponible', 'reservado', 'vendido'];
        if (!in_array($this->estado, $estadosValidos, true)) {
            throw new \Exception("Estado inválido. Debe ser: disponible, reservado o vendido.");
        }
    }

    public function vender(): void
    {
        if ($this->estado === 'reservado') {
            throw new \Exception("El auto está reservado.");
        }
        $this->estado = 'vendido';
        $this->version++;
    }

    private static function arrayToAuto(array $row): Auto
    {
        return new Auto(
            patente: $row['patente'],
            marca: $row['marca'],
            modelo: $row['modelo'],
            estado: $row['estado'],
            version: $row['version'] ?? 0,
            id: $row['id']
        );
    }
    public static function listar(): array
    {
        $pdo = null;
        $stmt = null;
        try {
            $pdo = Conexion::getPDOConnection();
            $sql = "SELECT id, patente,marca,modelo,estado, version FROM auto";
            $stmt = $pdo->query($sql);
            while ($row = $stmt->fetch()) {
                $auto = self::arrayToAuto($row);
                $autos[] = $auto;
            }
            //retornar los autos
            return $autos;
        } catch (PDOException $e) {
            error_log("Error al obtener autos: " . $e->getMessage());
            return [];
        } finally {
            $stmt = null;
            $pdo = null;
        }
    }
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'patente' => $this->patente,
            'marca' => $this->marca,
            'modelo' => $this->modelo,
            'estado' => $this->estado,
            'version' => $this->version,
        ];
    }

    public function getId(): int
    {
        return $this->id;
    }
    public function getPatente(): string
    {
        return $this->patente;
    }
    public function getModelo(): string
    {
        return $this->modelo;
    }
    public function getMarca(): string
    {
        return $this->marca;
    }
    public function getEstado(): string
    {
        return $this->estado;
    }
    public function getVersion(): int
    {
        return $this->version;
    }
}

<!-- Crea un interfaz JSerializable, de manera que ofrezca los métodos:
toJSON(): string → utiliza la función json_encode(mixed). Ten en cuenta que como 
tenemos las propiedades de los objetos privados, debes recorrer las propiedades y 
colocarlas en un mapa. -->

<?php
include_once('014Trabajador.php');
include_once('014InterfaceJson.php');
class Gerente extends Trabajador implements JSerializable{

    private float $salario;
    // Constructor {sueldo, contructorPadre(nombre, apellidos)}
    public function __construct(
        string $nombre, 
        string $apellidos,
        int $edad,
        private float $sueldo = 1000)
        {
            parent::__construct(
                $nombre,
                $apellidos,
                $edad);
        }
    
    //Setters

    //*NUEVA FUNCIÓN
    public function calcularSueldo()
    {
        $sueldo = $this->salario + $this->salario * $this->edad / 100;
        $this->sueldo = $sueldo;

        return $this;
    }
    
    public function setSalario($salario)
    {
        $this->salario = $salario;

        return $this;
    }

    // Getters
    public function getSalario()
    {
        return $this->salario;
    }

    public function getSueldo()
    {
        return $this->sueldo;
    }

  
    public function debePagarImpuestos(): bool{
        return ($this->sueldo > parent::$sueldoTope && $this->edad > 21) ? true : false;
    }


    public static function toHtml(Persona $p): string{
        if($p instanceof Gerente){
            //Datos generales en un String.
            $datosHTML = "<p>Nombre y Apellidos: ".$p -> getNombreCompleto()."<br>
                            Edad: ".$p -> getEdad()."<br>
                            Sueldo: ".$p -> getSueldo()."<br>
                            Impuestos: ".(($p -> debePagarImpuestos()) ? "Sí<br>" : "No<br>").
                            "Teléfonos:<br>";
            //Datos de teléfonos.
            $telefonosHTML = "<ol>".$p -> getTelefonos()."</ol></p>";
            //Concatenación de ambas cadenas para conseguir toHTML completo.
            $estructuraHTML = $datosHTML.$telefonosHTML;
            
        }else{ //Si la persona no es un empleado se mostrará solo su nombre y apellidos.
            $estructuraHTML = "<p>Nombre y Apellidos: ".$p -> getNombreCompleto()."<br>Edad: ".$p -> getEdad()."</p>";
            
        }
        return $estructuraHTML;
    }

    public function __toString(): string{
        $datosToString = "<p>Nombre y Apellidos: ".$this -> getNombreCompleto()."<br>
                            Edad: ".$this -> getEdad()."<br>
                            Sueldo: ".$this -> getSueldo()."<br>
                            Impuestos: ".(($this -> debePagarImpuestos()) ? "Sí<br>" : "No<br>").
                            "Teléfonos:<br>";
            //Datos de teléfonos.
            $telefonosToString = "<ol>".$this -> getTelefonos()."</ol></p>";
            //Concatenación de ambas cadenas para conseguir toHTML completo.
            $estructuraToString = $datosToString.$telefonosToString;

        return $estructuraToString;
    }

    public function toJSON(): string
    {
        $mapa = get_object_vars($this);

        return json_encode($mapa);
    }

    public function toSerialize(): string
    {
        return serialize($this);
    }

}


?>

<?php
class usuario
{   private $nombre;
    private $email;
    private $pass;

    public function __construct($nombre, $email, $pass, $UltimoLog, $activo, $es_admin)
    {
        $this->nombre= $nombre;
        $this->UltimoLog = $UltimoLog;
        $this->activo = $activo;
        $this->admin = $es_admin;
        $this->email = $email;
        $this->pass = $pass;
    }

    public function __toString()
    {
        return "$this->nombre . $this->email";

    }

    public function getnombre()
	{
		return $this->nombre;
	}

  public function getUltimoLog()
  {
  return $this->UltimoLog;
  }

    public function getemail()
	{
		return $this->email;
	}

    public function getpass()
	{
		return $this->pass;
	}

}

?>

<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dolar".
 *
 * @property integer $id
 * @property double $dolar
 * @property string $created_at
 */
class GetDolar extends Dolar
{
	private $url = null;
	private $time = 0; //in seconds
	private $call = 0;
	private $continue = true;
	private $initialized = null;

	public function __construct($url){
		echo $this->display("Iniciando captura do Dolar");

		$this->initialized = date("Y-m-d H:i:s");

		if(isset($url)){
			$this->url = $url;	
		}
	}

	public function setTime($time){
		$this->time = ($time * 60); //for setting in minutes
	}

	public function getTime(){
		return $this->time;
	}

	public function stopProgress(){
		$this->continue = false;
	}

	public function start(){
		while($this->continue == true)
		{
			echo $this->display("----------------------------------------------------------------------------------------------------------------");

			echo $this->display("Chamada numero = " . $this->call . " Iniciado em " . $this->initialized . " chamada atual " . date("Y-m-d H:i:s"));
			echo $this->display("Iniciando leitura da URL");
			echo $this->display("URL = " . $this->url);

			$fileContents = $this->getFileContents();
			if($fileContents)
			{
				echo $this->display("Conteudo resgatado = " . $fileContents);

				$json = json_decode($fileContents);
				
				$valueDolar = $json->query->results->rate->Ask;

				echo $this->display("Dolar resgatado = " . $valueDolar);

				$this->saveIfChanged($valueDolar);

				$this->call++;

				echo $this->display("Esperando " . $this->time . " segundos para nova consulta");
				sleep($this->time);
				echo $this->display("----------------------------------------------------------------------------------------------------------------");
			}
		}
	}

	private function saveIfChanged($valueDolar){
		$dolar = new Dolar();
		$lastValuesDolar = (float) $dolar->find()->orderBy('id DESC')->one()->dolar;

		if((float) $valueDolar == (float) $lastValuesDolar){
			echo $this->display("Dolar não salvo Motivo: mesmo valor Salvo = $lastValuesDolar Resgatado = $valueDolar");
		}else{
			echo $this->display("Dolar salvo alteracao de " . ($valueDolar - $lastValuesDolar) . " Valor Salvo = ".$lastValuesDolar." Resgatado = ".$valueDolar."");

			$dolar->dolar = $valueDolar;
			if($dolar->save()){
				echo $this->display("Dolar Salvo em : " . $valueDolar);
			}else{
				echo $this->display("Dolar Não Salvo em : " . $valueDolar);
			}
		}
	}

	private function display($message){
		return $message . "\n\n";
	}

	private function getFileContents(){
		try{
			return file_get_contents($this->url);		
		}catch(yii\base\ErrorException $e){
			$this->display('Exceção capturada: ',  $e->getMessage());
		}
		return false;
	}
}
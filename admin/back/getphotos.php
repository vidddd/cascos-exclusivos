<?php
ini_set('include_path', '..');

		$state = (string)$_POST['state'];
		$inicio = (string)$_POST['inicio'];
		$items = (string)$_POST['items'];

		echo getItems($state,$inicio,$items);

function getItems($state,$inicio,$items) {

		require '../lib/settings.php';
		require '../lib/conexion.php';

		$where = "where estado = ".$state;
		$order = "order by time desc";
		$limits =  "limit ".$inicio.",".$items;
		$i=0;
		echo $sql = "select * from participaciones ".$where." ".$order." ".$limits.";";
		$cadena = "";

		$html = "";
		switch($state){
			case 3:
				$btns = '<a><img src="img/ok.png" width="25" height="25" alt="Aceptar" onclick="change(2,this)"/></a>';
				break;
			case 2:
				$btns = '<a><img src="img/ko.png" width="25" height="25" alt="Rechazar" onclick="change(3,this)"/></a>';
				break;
			case 1:
				$btns = '<a><img src="img/ko.png" width="25" height="25" alt="Rechazar" onclick="change(3,this)"/></a>
						<a><img src="img/ok.png" width="25" height="25" alt="Aceptar" onclick="change(2,this)"/></a>';
				break;
		}
		if($result = $mysqli->query($sql)){
			while($obj = $result->fetch_object())
			{
				$i++;

				$html.='<div class="item" id="item_'.$obj->id.'">
							<div class="img_red">
								<img src="../'.$obj->foto.'" />
							</div>
							<div class="txt_red">
							  <p>'.utf8_encode($obj->nombre).'</p>
							</div>
							 <div class="btn_red">

												'.$btns.'
							 </div>
						  </div>';
			}

			if($i==0){
				$html.= '<h2 style="width:100%; margin-top:124px; text-align:center;"> No hay registros en esta seccion</h2>';
			}
		}

		$html .= '<div class="clear"></div>';

		if ($inicio == 1)
		{
			if ($i>$items-1)
			{
			$html .= '<div id="pag_nav"><span class="" onclick="llenar('.($inicio+$items).','.$state.')"><img src="img/next.png"/></span></div>';
			}
		}
		else
		{
			if ($i<$items)
			{
			$html .= '<div id="pag_nav"><span class="" onclick="llenar('.($inicio-$items).','.$state.')"><img src="img/prev.png"/></span></div>';
			}
			else{
			$html .= '<div id="pag_nav"><span class="" onclick="llenar('.($inicio-$items).','.$state.')"><img src="img/prev.png"/></span><span class="" onclick="llenar('.($inicio+$items).','.$state.')"><img src="img/next.png"/></span></div>';
			}
		}
		return $html;
		require '../lib/close.php';
}
?>

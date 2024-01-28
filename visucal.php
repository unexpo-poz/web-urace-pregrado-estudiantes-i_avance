<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Sistema de consulta de calificaciones</title>
<link rel="StyleSheet" href="estilos.css" type="text/css">
<script language="javascript" src="asrequest.js" type="text/javascript"></script>

 
</head>

<?php

require_once('odbc/config.php');//este tambien esta agregado en cada funcion
require_once("odbc/odbcss_c.php");
require_once("odbc/guardar.php");
if($_SERVER['HTTP_REFERER']!=$raizDelSitio.'planilla_r.php') die ("<script languaje=\"javascript\"> alert('ACCESO PROHIBIDO!'); </script>");


$exp_e=$_POST['exp_e'];
$conex = new ODBC_Conn($basededatos,$usuariodb,$clavedb,TRUE,$LBT);
$mSQL  = "select a.apellidos,a.nombres,a.ci_e,b.carrera,a.c_uni_ca from dace002 a,tblaca010 b where a.exp_e='$exp_e' and b.c_uni_ca=a.c_uni_ca";
$conex->ExecSQL($mSQL,__LINE__,true);
$estu = $conex->result;
$mSQL  = "select a.acta,a.seccion,b.c_asigna,c.asignatura,b.ci,d.apellido||', '||nombre  from dace006 a,tblaca004 b,tblaca008 c,tblaca007 d  where b.acta=a.acta and b.c_asigna=b.c_asigna and b.lapso='$lapsoProceso' and a.lapso='$lapsoProceso' and a.exp_e='$exp_e' and c.c_asigna=b.c_asigna and a.acta=b.acta and a.seccion=b.seccion and b.ci=d.ci AND a.status IN ('A',7)";
$conex->ExecSQL($mSQL,__LINE__,true);
$result = $conex->result;
$cantalu=0;
echo '<table width="1000" >
  <tr><td align="center" >
  <table width="100%" align="center"><tr>
    <td width="100%" height="88" align="center|">';
	include("odbc/encabezado.php");
	echo'</td></tr><tr><td align="center">';
	echo '<hr>';
	include("odbc/datosestudiante.php");	
	echo '<hr></td></tr><tr><td width="100%" align="center"><p align="center"><strong>CALIFICACIONES</strong><br><span style="font-family:Arial;color:#FF0000;">Si alguna asignatura no se muestra en la lista, es posible que el acta ya se haya cerrado. Consulta tu record acad&eacute;mico.</span></p>';
	?>
	<select name="seleccal" id="seleccal" class="datospf" OnChange="fajax('./odbc/guardar.php','calificaciones','codigos=987789&valor='+this.value+'&exp_e=<? echo $exp_e;?>','post','0');">
	
		  <option value="" selected="selected">&lt;&lt; Seleccione la materia a consultar &gt;&gt;</option>
		  
          <?php while($result[$cantalu][0]!=NULL)
		  {
		  echo '<option value="'.$result[$cantalu][0].'">'.$result[$cantalu][3].'</option>';
		  $cantalu++; 
		  }?>
         		</select><hr><br>
				<div id="calificaciones"></div>
	
	<?php


/*	
while($result[$cantalu][0]!=NULL)
				{
				
					
				
					
	

			
			if($datos[0][0]!=NULL){	
				$ca=0;////////////////////////
				$num=1;
			while($datos[$ca][0]!=NULL)///////////////////////
				{
			echo '<tr>';
			if($datos[$ca][39]!=7)
			{//////////////
			if($datos[$ca][39]=='R') echo	'<td><strong>Ret. Reglam</strong></td>';///////////////
			if($datos[$ca][39]=='A') echo	'<td><strong>Agregado</strong></td>';/////////////
			if($datos[$ca][39]==2) echo	'<td><strong>Retirado</strong></td>';//////////////////////
			$ca++;
			}
			else echo	'<td><strong></strong></td>';
				for($i=0;$i<=$cantee+1;$i++) echo '<td align="center">'.$datos[$cantalu][$i].'</td>';
				if($activasta==1 && $datos[$cantalu][37]<50) $color='style="background:#FF0000; color:black; font-family:arial; font-weight:bold;"';
				echo '<td align="center" '.$color.' >'.$datos[$cantalu][37].'</td>';
				$color='';
				if($activasta==1 && $datos[$cantalu][38]<5) $color='style="background:#FF0000; color:black; font-family:arial; font-weight:bold;"';
				echo '<td align="center" '.$color.' >'.$datos[$cantalu][38].'</td>';
			echo '</tr>';
				$ca++;
				$num++;
				}
			echo '<tr><td colspan="3"><strong>FECHAS DE CARGA</strong></td>';	
				for($i=0;$i<$cantee;$i++) echo '<td align="center">'.implode("/",array_reverse(explode("-",$fechas[0][$i]))).'</td>';
				echo '</tr>';
				echo '</table>';
				echo '</td></tr>';
				echo '</table>';
				}				
				$cantalu++;
				echo '<hr>';
				}
*/?>
</td></tr><tr><td align="center" colspan="38">

          <input type="button" name="imprimir" value="Imprimir" class="boton" style="background:#FFFF33; color:black; font-family:arial; font-weight:bold;" onclick="window.print();">&nbsp;&nbsp;&nbsp;<input type="button" value="Salir" name="B1" class="boton" onclick="javascript:self.close();">

    </td>
  </tr></table></td></tr></table>
<body>

</body>
</html>

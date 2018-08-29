<div id='nos'>
<section id='slider'>
	<div id="amazingslider-wrapper-1" style="display:block;position:relative;width:90vw;margin:0px auto 48px;">
        <div id="amazingslider-1" style="display:block;position:relative;margin:0 auto;">
            <ul class="amazingslider-slides" style="display:none;">
                <li><img src="slider/images/1.jpg" alt='1'/>
                </li>
                <li><img src="slider/images/2.jpg" alt='2'/>
                </li>
                <li><img src="slider/images/3.jpg" alt='3'/>
                </li>
                <li><img src="slider/images/4.jpg" alt='4'/>
                </li>
                <li><img src="slider/images/5.jpg" alt='5'/>
                </li>
                <li><img src="slider/images/6.jpg" alt='6'/>
                </li>
                <li><img src="slider/images/7.jpg" alt='7'/>
                </li>
                <li><img src="slider/images/8.jpg" alt='8'/>
                </li>
                <li><img src="slider/images/9.jpg" alt='9'/>
                </li>
                <li><img src="slider/images/10.jpg" alt='10'/>
                </li>
                <li><img src="slider/images/11.jpg" alt='11'/>
                </li>
                <li><img src="slider/images/12.jpg" alt='12'/>
                </li>
                <li><img src="slider/images/13.jpg" alt='13'/>
                </li>
                <li><img src="slider/images/14.jpg" alt='14'/>
                </li>
                <li><img src="slider/images/15.jpg" alt='15'/>
                </li>
                <li><img src="slider/images/16.jpg" alt='16'/>
                </li>
            </ul>
        </div>
    </div>
</section>
<div>
<h2>Sobre Nosotros</h2>

<?php 
	$dir = opendir( "txt" );
	while($i = readdir($dir) ){
		if($i == '.' || $i == '..' ){continue;}
		if( file_exists("txt/info.txt")){	
			echo "<p>".nl2br(file_get_contents("txt/info.txt"))."</p>";
		}
	}
	closedir($dir);
?>	
<div id="trabajo">
<h2>Sobre este trabajo</h2>
<p>
Sitio web con sistema de ABM para manejo de contenidos en PHP y MySQL. <br/>
Tanto usuarios como administradores pueden realizar publicaciónes de mascotas perdidas, encontradas o en adopción y estos últimos pueden editar las mismas desde un panel de control con verificación de permisos. Los usuarios pueden editar la información de sus perfiles. </p>

<p>Este sitio fue testeado en: Google Chrome 46.0, Mozilla Firefox 42.0 e Internet Explorer 11.0 con éxito.<br/>

</div>

</div>
</div>
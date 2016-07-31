<?php
/**
 * Created by PhpStorm.
 * User: Belgemre PC
 * Date: 30.7.2016
 * Time: 01:02
 */

include 'header.php';
?>
<div class="container ana">

    <a href="arabayaatilan-ayar.php"><!--başlatılmış servise git-->
        <div class="main">
            <i class="fa fa-sign-in fa-2x pull-right"></i> <b class="f16">Servis Başlat</b>
        </div>
    </a>


    <a href="hesaptopla.php">
        <div class="main green">
            <i class="fa fa-try fa-2x pull-right" aria-hidden="true"></i> <b class="f16">Hesap Topla</b>
        </div>
    </a>


    <a href="guzergahlarim.php">
        <div class="main gri" data-toggle="tooltip" data-placement="bottom"
             title="Güzergahtaki müşterilerin sıralarını değiştirebilirsiniz.">
            <i class="fa fa-random fa-2x pull-right"></i> <b class="f16">Güzergahım</b>
        </div>
    </a>


</div>
<?php include 'footer.php'; ?>
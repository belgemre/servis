<?php
require('../includes/config.php'); 
////////////////////// ///////////////////////////////////////////////////////////////////////////////////////////////////////////////  ARABAYA ATILAN
if(isset($_POST['urun']) && isset($_POST['adet']) ){
	
			$servistur = trim(@$_POST['servistur']);
			$arac = trim(@$_POST['arac']);
			$urun = trim(@$_POST['urun']);
			$adet = trim(@$_POST['adet']);
			date_default_timezone_set('Europe/Istanbul');
			$tarih =  date('d.m.Y');
			$saat =  date('H:i');
			$araba = trim(@$_POST['araba']);
			
			
			$servis_sorgu = $db->prepare("SELECT * FROM arabayaatilan 
			where 
			servis_id=$servistur && 
			urun_id = $urun &&
			arac_id = $arac &&
			tarih = '$tarih'
			
			");
			$servis_sorgu->execute();

			if($servis_sorgu->rowCount()){
				echo 1;			
			}else{
				$stmt = $db->prepare('INSERT INTO arabayaatilan (tarih,saat,arac_id,urun_id,adet,servis_id) 
				VALUES (:tarih, :saat, :arac, :urun, :adet, :servistur)');
						$stmt->execute(array(
							':tarih' => $tarih,
							':saat' => $saat,
							':arac' => $arac,
							':urun' => $urun,
							':adet' => $adet,
							':servistur' => $servistur
						));
						echo 2;
			}
}
////////////////////// ///////////////////////////////////////////////////////////////////////////////////////////////////////////////  MÜŞTERİYE ÜRÜN VER
if( isset($_POST['musterimiz']) && isset($_POST['bsidmiz']) && isset($_POST['verilenurun']) && isset($_POST['verilenadet']) ){
			$musteri = trim(@$_POST['musterimiz']);
			$bsid=trim(@$_POST['bsidmiz']);
			$urun = trim(@$_POST['verilenurun']);
			$vadet = trim(@$_POST['verilenadet']);
			date_default_timezone_set('Europe/Istanbul');
			$tarih =  date('d.m.Y');
			$saat =  date('H:i');
			
			$verilenurun_sorgu = $db->prepare("SELECT * FROM satisdetaylari 
			where 
			bs_id=$bsid && 
			musteri_id =$musteri &&
			urun_id = $urun 			
			");
			$verilenurun_sorgu->execute();

			if($verilenurun_sorgu->rowCount()){
				echo 1;
								
			}else{
				
				$stmt = $db->prepare("SELECT * FROM yapilanservisler where bs_id=$bsid");
				$stmt->execute();
				$ys = $stmt->fetch(PDO::FETCH_ASSOC);
				$arac_id = $ys['arac_id'];
				$servis_id = $ys['servis_id'];
				
				$aa = $db->prepare("SELECT * FROM arabayaatilan where tarih='$tarih' and arac_id=$arac_id and servis_id=$servis_id and urun_id=$urun"); 
				$aa->execute();
				$asayi=$aa->fetch(PDO::FETCH_ASSOC);
				$asayisi=$asayi['adet'];
				
				$sa = $db->prepare("SELECT sum(adet),urun_id FROM satisdetaylari where bs_id=$bsid and urun_id=$urun group by urun_id"); 
				$sa->execute();
				$ssayi=$sa->fetch(PDO::FETCH_ASSOC);
				$ssayisi=$ssayi['sum(adet)'];
				
				$kalan=$asayisi-$ssayisi;
				if($vadet<=$kalan){
					$stmt = $db->prepare('INSERT INTO satisdetaylari (tarih,saat,musteri_id,urun_id,adet,bs_id) 
				VALUES (:tarih, :saat, :musteri, :urun, :adet, :bsid)');
						$stmt->execute(array(
							':tarih' => $tarih,
							':saat' => $saat,
							':musteri' => $musteri,
							':urun' => $urun,
							':adet' => $vadet,
							':bsid' => $bsid
						));
						echo 3;
				}else{
					echo 2;	
				}
				
			}
			
}
////////////////////// ///////////////////////////////////////////////////////////////////////////////////////////////////////////////  SERVİS ALINAN PARA
if( isset($_POST['musterihesap']) && isset($_POST['bsidhesap']) && isset($_POST['apara']) && isset($_POST['tthesap']) ){
			
			$musteri = trim(@$_POST['musterihesap']);
			$bsid=trim(@$_POST['bsidhesap']);
			$para = trim(@$_POST['apara']);
			$tthesap = trim(@$_POST['tthesap']);
			date_default_timezone_set('Europe/Istanbul');
			$tarih =  date('d.m.Y');
			$saat =  date('H:i');
			
			$stmt = $db->prepare('INSERT INTO satishesaptakip (tarih,saat,musteri_id,bs_id,tutar,alinan) 
				VALUES (:tarih, :saat, :musteri, :bsid, :tutar, :alinan)');
						$stmt->execute(array(
							':tarih' => $tarih,
							':saat' => $saat,
							':musteri' => $musteri,
							':tutar' => $tthesap,
							':alinan' => $para,
							':bsid' => $bsid
						));
						echo 1;
			
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////     GÜZERGAH TÜRÜ GETİR  

if(isset($_POST['guzergah'])){
	$guzergahlist   = implode(',', $_POST['guzergah']);
	
	
	$guzergah_sorgu = $db->prepare("SELECT * FROM musteriler A JOIN guzergahlar B on A.liste=B.guzergah_id where A.liste='$guzergahlist'");
	$guzergah_sorgu->execute(); 
	$musteri = $guzergah_sorgu->fetch(PDO::FETCH_ASSOC);

	if($musteri){
		echo "<span class='f14 gri'><b class='red'>".$musteri['guzergah_adi']."</b> güzergahındaki müşteriler.  <i class='fa fa-random pull-right'></i></span>
			<div style='clear:both'></div><hr class='m5top m5bottom' />
				
			<ul><li id='listeId_guncelle' style='display: none;'></li>";
						
		$veriler = $db->prepare("SELECT m_id,musteri,m_adres FROM musteriler  where liste='$guzergahlist' Order By sira Asc");
		$veriler->execute();
		
			while( $lst = $veriler->fetch(PDO::FETCH_ASSOC) ) {  

				echo "<li id='listeId_".$lst['m_id']."'><b><u>".$lst['musteri']."</u></b> - ".$lst['m_adres']."</li>";
				
			}
		echo "</ul>";	
		echo " 	<script type='text/javascript'>
			$(document).ready(function(){ 
			$('#liste ul').sortable({opacity: 0.5, update: function(){
				var siralama = $(this).sortable('serialize');
				$.post('db/db.php', siralama);											 
			}});
		});	
	</script>";
	}else{
		echo "<span class='f14 gri'><b class='red'>Seçilen güzergahta müşteri bulunamadı.</b>   <i class='fa fa-warning fa-2x pull-right red'></i></span>";
	}
		


	
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////  HESAP TOPLA MÜŞTERİ SEÇİM KISMI 

if(isset($_POST['guzergahHesap'])){
	$guzergahlist   = implode(',', $_POST['guzergahHesap']);
	
	
	$guzergah_sorgu = $db->prepare("SELECT * FROM musteriler A JOIN guzergahlar B on A.liste=B.guzergah_id where A.liste='$guzergahlist'");
	$guzergah_sorgu->execute(); 
	$musteri = $guzergah_sorgu->fetch(PDO::FETCH_ASSOC);

	if($musteri){
		echo "<span class='f14 gri'><b class='red'>".$musteri['guzergah_adi']."</b> güzergahındaki müşteriler.  <i class='fa fa-random pull-right'></i></span>
			<div style='clear:both'></div><hr class='m5top m5bottom' />
				
			<ol id='selectable'>";
						
		$veriler = $db->prepare("SELECT m_id,musteri FROM musteriler  where liste='$guzergahlist' Order By sira Asc");
		$veriler->execute();
		
			while( $lst = $veriler->fetch(PDO::FETCH_ASSOC) ) {  

				echo "<li id='".$lst['m_id']."'><b><u><i id='data-id".$lst['m_id']."' id='check-icon' class=\"fa fa-check m5right none\" aria-hidden=\"true\"></i>".$lst['musteri']."</u></b></li>";
				
			}
		echo "</ol>";	
		echo " 	<script type='text/javascript'>

			$(function() {
				
				$(\"#selectable\").bind(\"mousedown\", function(evt) {
					evt.metaKey = true;
					
				}).selectable({
							stop: function() {
								var result =[]
								$( \"li.ui-selected\", this ).each(function() {
									result.push( this.id);
									
								});
								$( \"#select-result\" ).val(result.join(','))
							
							}
						});   
				});
	</script>";
	}else{
		echo "<span class='f14 gri'><b class='red'>Seçilen güzergahta müşteri bulunamadı.</b>   <i class='fa fa-warning fa-2x pull-right red'></i></span>";
	}
		


	
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// ÇIKAN ÜRÜNLER RAPOR KISMI
if(isset($_POST['trh'])){
	
	$trh=trim(@$_POST['trh']);	
	function tarihDuzenle($trh){
		return implode('.',array_reverse(explode('-',$trh)));
	}
	$tarih=tarihDuzenle($trh);
	
	
	
	$ta_sorgu = $db->prepare("SELECT * FROM arabayaatilan where tarih=?");
	$ta_sorgu->execute(array($tarih));
		if($ta_sorgu->rowCount()){
			$stmt = $db->prepare("SELECT tarih,urun_adi,sum(adet),birimi FROM arabayaatilan A JOIN urunler B ON A.urun_id=B.urun_id  where A.tarih='$tarih' group by A.urun_id ");
			$stmt->execute();
			$sayi=0;
			
			echo "
					<thead>
						<tr>
							<th>S.N</th>
							<th>Ürünler</th>
							<th>Birim Miktar</th>
						</tr>
					</thead>
					<tbody class='searchable'>";
			
			while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) { 
			
			
			echo "
			<tr>
				<td>".$sayi=1+$sayi."</td><td>".$row['urun_adi']."</td>
				<td >".$row['sum(adet)']." ".$row['birimi']."</td>
			</tr>
			";
			}
			echo "</tbody>";
		}else{
			echo "<tr class='red' style='background:#fff;'><td style='border-right:0 none;'></td><td style='border-right:0 none;' class='text-center'><b>".$tarih." tarihinde ürün çıkışı olmamış ya da kaydedilmemiş!</b></td><td></td></tr>";
		}

}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// ÇIKAN ÜRÜNLER RAPOR KISMI
if(isset($_POST['servis_turu']) && isset($_POST['guzergahtur']) ){
	$guzergah=@$_POST['guzergahtur'];
	$arac=@$_POST['arac'];
	$servis_turu=@$_POST['servis_turu'];
	$servisci=@$_POST['servisci'];
	
	date_default_timezone_set('Europe/Istanbul');
	$tarih =  date('d.m.Y');
	$saat =  date('H:i');
	
	$stmt = $db->prepare('INSERT INTO yapilanservisler (servisci_id,servis_id,arac_id,guzergah_id,tarih,baslangic_saati) 
				VALUES (:servisci_id, :servis_id, :arac, :guzergah_id, :tarih, :baslangic_saati)');
						$stmt->execute(array(
							':servisci_id' => $servisci,
							':servis_id' => $servis_turu,
							':arac' => $arac,
							':guzergah_id' => $guzergah,
							':tarih' => $tarih,
							':baslangic_saati' => $saat
						));
						$lastidmiz= $db->LastInsertID();
						echo $lastidmiz;
}
?>
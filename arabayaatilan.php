<?php include 'header.php'; ?>
<?php $sayi = 1; ?>
    <script>
        function eklebtnn() {

            var servistur = $('input[name=servistur]').val();
            var servisci = $('input[name=servisci]').val();
            var arac = $('input[name=arac]').val();
            var urun = document.getElementById("urun").value;
            var adet = $('input[name=adet]').val();


            if (servistur != "" && arac != "" && urun != "" && adet != "") {

                $.ajax({
                    type: 'POST',
                    url: 'function.php',
                    data: $('#arabayaatilanlar').serialize(),
                    success: function (data) {
                        if (data == 1) {
                            $('.hatamesaji').text("Seçilen ürün zaten seçilen arabaya atılmış. Güncellemeyi deneyiniz.").fadeIn(0).fadeOut(5000);
                        } else if (data == 2) {
                            $('.hatamesaji').text("");
                            windows.location.reload(true);
                        } else {
                            alert("Beklenmedik bir hata oluştu!");
                        }
                    },
                    error: function () {
                        alert("Başarısız");
                    }
                });
                return false;


            } else {
                alert("Boş alanlar var.");
            }
        }
    

        function servisbaslat() {
            var servistur = $('input[name=servis_turu]').val();
            var servisci = $('input[name=servisci]').val();
            var arac = $('input[name=arac]').val();
            var guzergahtur = $('input[name=guzergahtur]').val();
            
			if (servistur != "" && servisci != "" && arac != "" && guzergahtur != "") {

                $.ajax({
                    type: 'POST',
                    url: 'function.php',
                    data: $('#servisbasladiform').serialize(),
                    success: function (data) {
                        window.location.href = 'servis-basladi.php?bs_id=' + data;
                    },
                    error: function () {
                        alert("Başarısız");
                    }
                });
                return false;


            }

        }

    </script>

    <div class="container ana">
        <?php
        date_default_timezone_set('Europe/Istanbul');
        $tarih = date('d.m.Y');

        if (isset($_POST['servistur'])) {

            $servisturu = trim(@$_POST['servistur']);
            $servisci = 84;

            $aracgetir = $db->prepare("SELECT * FROM araclar where atipi='Servis' and kullanan_personel =$servisci ");
            $aracgetir->execute();
            $araclar = $aracgetir->fetch(PDO::FETCH_ASSOC);
            $arac_id = $araclar['arac_id'];

            $stmt = $db->prepare("SELECT * FROM serviscesit where servis_id = $servisturu ");
            $stmt->execute();
            $serviscesit = $stmt->fetch(PDO::FETCH_ASSOC);
			
			$guzergahgetir = $db->prepare("SELECT * FROM guzergahlar where tanimli_personel =84 ");
            $guzergahgetir->execute();
            $guzergahlar = $guzergahgetir->fetch(PDO::FETCH_ASSOC);
			$guzergah_id=$guzergahlar['guzergah_id'];

        } else {
            header('Location: arabayaatilan-ayar.php');
        }

        ?>
        <div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1 well">
            <div class="row text-center">
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <label><u>Servis Türü</u></label><br />
                        <label><b class="red"><?php echo $serviscesit['servis_adi']; ?></b></label>
                    </div>

                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <label><u>Araç</u></label> <br />
                        <label><b class="red"><?php echo $araclar['marka'] . " " . $araclar['model']; ?></b></label>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1 well">
            <span class="f16 gri">Aracınıza Ürün Yükleyin</span>
            <div class="clr"></div>
            <hr class="m5top m5bottom"/>
            <form role="form" method="post" id="arabayaatilanlar" action="" onsubmit="return false;">
                <div class="row">
                    
                            <input type="text" class="form-control none" name="servistur" id="servistur"
                                   value="<?php echo $servisturu; ?>"/>
                       
                            <input type="text" class="form-control none" name="arac" id="arac"
                                   value="<?php echo $arac_id; ?>"/>
                     
					
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-4 col-md-4">
                        <div class="form-group">
                            <label>Ürün:</label>
                            <select class="form-control form country" name="urun" id="urun" required>
                                <option value="">Ürün Seç</option>
                                <?php
                                $stmt = $db->prepare("SELECT * FROM urunler ");
                                $stmt->execute();
                                while ($urunler = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    ?>
                                    <option
                                        value="<?php echo $urunler['urun_id']; ?>"><?php echo $urunler['urun_adi']; ?></option>
                                <?php } ?>
                            </select>
                        </div>

                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4">
                        <div class="form-group">
                            <label>Miktar:</label>W
                            <input type="number" pattern="\d*" class="form-control" name="adet" placeholder="250" required/>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-4 col-md-4">
                        <div class="form-group">
                            <button type="submit" name="ekle" id="eklebtn" onClick="eklebtnn()"
                                    class="btn btn-primary btn-lg btn-block" style="margin-top:25px">Kaydet
                            </button>
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <p class=""><label class="hatamesaji red m15top" id="hatamesaji"></label></p>
                </div>
            </form>

        </div>

        <div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1 well">
            <span class="f16 gri">Aracınıza Yüklenen Ürünler Tablosu<i class="fa fa-filter pull-right"></i></span>
            <div class="clr"></div>
            <hr class="m5top m5bottom"/>
            <div class="table-responsive">

                <table class="table " cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>S.N</th>
                        <th>Sil</th>
                        <th>Ürün Adı</th>
                        <th>Birim Miktar</th>


                    </tr>
                    </thead>
                    <tbody>
                    <?php

                    $stmt = $db->prepare("SELECT * FROM arabayaatilan A JOIN urunler B ON A.urun_id=B.urun_id where A.tarih='$tarih' and A.servis_id=$servisturu and arac_id=$arac_id");
                    $stmt->execute();
                    while ($arabayaatilan = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                        <tr class="btnDelete" data-id="<?php echo $arabayaatilan['id']; ?>">
                            <td><label><?php echo $sayi; ?></label></td>
                            <td><a class="btnDelete" href=""><i class="fa fa-trash bordo"></i></a></td>

                            <td><label><?php echo $arabayaatilan['urun_adi']; ?></label></td>
                            <td>
                                <a href="#" data-toggle='modal'
                                   data-target='.bs-example-modal-sm-guncelle<?php echo $sayi; ?>'><i
                                        class="fa fa-pencil"></i></a>
                                <label><?php echo $arabayaatilan['adet']; ?></label>
                                <label><?php echo $arabayaatilan['birimi']; ?></label>

                            </td>

                        </tr>

                        <!-- ÜRÜN MİKTAR GÜNCELLE MODAL-->

                        <div class="modal fade bs-example-modal-sm-guncelle<?php echo $sayi; ?>" tabindex="-1"
                             role="dialog" aria-labelledby="mySmallModalLabel">
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="myModalLabel">Ürün Güncelle</h4>
                                    </div>
                                    <div class="modal-body">
                                        <form role="form" method="post" id="aaguncelle<?php echo $sayi; ?>" action=""
                                              onsubmit="return false;">

                                            <input type="text" class="none" name="aagid<?php echo $sayi; ?>"
                                                   value="<?php echo $arabayaatilan['id']; ?>"/>
                                            <div class="form-group">
                                                <label>Ürün Adı :</label>
                                                <input type="text" class="form-control"
                                                       value="<?php echo $arabayaatilan['urun_adi']; ?>" disabled/>
                                            </div>
                                            <div class="form-group">
                                                <label>Adet / kg / koli :</label>
                                                <input type="text" class="form-control" name="gadet<?php echo $sayi; ?>"
                                                       id="gadet<?php echo $sayi; ?>"
                                                       onClick="temizadet<?php echo $sayi; ?>()"
                                                       placeholder="Adet / koli / kg" name="adetguncel"/>
                                            </div>
                                        </form>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-success btn-block"
                                                onClick="aguncelle<?php echo $sayi; ?>()">GÜNCELLE
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <script type="text/javascript">
													
                            function aguncelle<?php echo $sayi; ?>(){
                                var aagid<?php echo $sayi; ?> = $('input[name=aagid<?php echo $sayi; ?>]').val();
                                var gadet<?php echo $sayi; ?> = $('input[name=gadet<?php echo $sayi; ?>]').val();

                                if (aagid<?php echo $sayi; ?>!= "" && gadet<?php echo $sayi; ?>!= "") {
                                    $.ajax({
                                        type: 'POST',
                                        url: 'guncellemeler.php',
                                        data: {gid: aagid<?php echo $sayi; ?>, gadet: gadet<?php echo $sayi; ?>},
                                        success: function (data) {
                                            if (data == 1) {
                                                location.reload();
                                            } else {
                                                alert("Beklenmedik bir hata oluştu!");
                                            }
                                        },
                                        error: function () {
                                            alert("Başarısız");
                                        }
                                    });
                                    return false;

                                } else {
                                    document.getElementById("gadet<?php echo $sayi; ?>").classList.add('hata');
                                }
                            }
                            function temizadet<?php echo $sayi; ?>() {
                                document.getElementById("gadet<?php echo $sayi; ?>").classList.remove('hata');
                            }


                        </script>
                        <?php $sayi = $sayi + 1;
                    } ?>
                    </tbody>
                </table>
            </div><!--Responsive Table Son-->
			<form role="form" method="post" id="servisbasladiform" action="" onsubmit="return false;">
							<input type="text" class="form-control none" name="servis_turu" id="servis_turu"
                                   value="<?php echo $servisturu; ?>"/>
                       
                            <input type="text" class="form-control none" name="arac" id="arac"
                                   value="<?php echo $arac_id; ?>"/>
                      
                            <input type="text" class="form-control none" name="guzergahtur" id="guzergahtur"
                                   value="<?php echo $guzergah_id; ?>"/>
								   
							<input type="text" class="form-control none" name="servisci" id="servisci"
                                   value="<?php echo $servisci; ?>"/>
			</form>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                    <button type="submit" style="margin-top:25px;" onClick="servisbaslat()"
                            class="btn btn-primary btn-lg btn-block">Bu Servisi Başlat
                    </button>
                </div>
            </div>

        </div>

    </div><!----- Container Son ---->

    <!-- Small modal SİL-->
<?php include 'modal/silmodal.php'; ?>


    <script>
        $('a.btnDelete').on('click', function (e) {
            e.preventDefault();
            var id = $(this).closest('tr').data('id');
            $('#silmodal').data('id', id).modal('show');
        });

        $('#btnDelteYes').click(function () {
            var id = $('#silmodal').data('id');
            if (id != "") {
                $.ajax({
                    type: 'POST',
                    url: 'sil.php',
                    data: 'id=' + id,
                    success: function (data) {
                        if (data == 1) {
                            $('#silmodal').modal('hide');
                            $('[data-id=' + id + ']').animate({backgroundColor: "#fbc7c7"}, "fast")
                                .animate({opacity: "hide"}, "slow");
                        } else {
                            alert("Beklenmedik bir hata oluştu!");
                        }
                    },
                    error: function () {
                        alert("Başarısız");
                    }
                });
                return false;

            } else {
                alert("boş var");
            }


        });
    </script>
<?php include 'footer.php'; ?>
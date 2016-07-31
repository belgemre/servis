<?php include 'header.php'; ?>

    <div class="container ana">


        <div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1 well">
            <span class="f18 gri ">Servis Başlat <i class="fa fa-sign-in pull-right"></i></span>
            <div class="clr"></div>
            <hr class="m15top m15bottom"/>
            <form role="form" method="post" action="arabayaatilan.php">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label>Servis Türü:</label>
                            <select name="servistur" id="servistur" class="form-control form" required>
                                <option value="">Servis Türü</option>
                                <?php
                                $stmt = $db->prepare("SELECT * FROM serviscesit");
                                $stmt->execute();
                                while ($serviscesit = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    ?>
                                    <option
                                        value="<?php echo $serviscesit['servis_id']; ?>"><?php echo $serviscesit['servis_adi']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="form-group">
                            <button type="submit" name="kydt" style="margin-top:25px;"
                                    class="btn btn-primary btn-lg btn-block">Başlat
                            </button>
                        </div>
                    </div>
                </div>

            </form>

        </div>

    </div><!----- Container Son ---->
<?php include 'footer.php'; ?>
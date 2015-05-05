    <div class="panel-group" id="accordion">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" class="collapseLink" data-parent="#accordion"
                    href="#collapseOne">
                        <i class="fa fa-bars"></i> Información General
                    </a>
                    <a href="negocio.php" class="fancybox2 fancybox.iframe"><span class="right"><i class="fa fa-edit"></i> Editar</span></a>
            </h4>
        </div>
        <div id="collapseOne" class="panel-collapse collapse in">
            <div class="panel-body">
                <label class="blue strong">R.F.C.: </label><label
                class="blue"><?php echo $rfc; ?></label><br>
                <label class="blue strong">TITULAR: </label><label
                class="blue"><?php echo $mainCustomer; ?></label><br>
                <label class="blue strong">DOMICILIO: </label><label
                class="blue"><?php echo $addressCustomer; ?></label>
            </div>
        </div>
    </div>
</div>
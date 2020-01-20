<div style="height: 60px;    background: rgb(255, 255, 255);
    background: -moz-linear-gradient(top, rgb(255, 255, 255) 0%, rgb(247, 247, 247) 100%);
    background: -webkit-linear-gradient(top, rgb(255, 255, 255) 0%, rgb(247, 247, 247) 100%);
    background: linear-gradient(to bottom, rgb(255, 255, 255) 0%, rgb(247, 247, 247) 100%);
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffffff', endColorstr='#f7f7f7', GradientType=0);
    border: 1px solid rgba(0, 0, 0, 0.11);" class="bg-faded  text-black fixed-bottom">
    <div class="container" style="padding-top: 10px;  ">
        JavaScript: <span id="manJSEnabled" class="badge badge-danger">Off</span>
        |
        AJAX Available: <span class="badge badge-danger">No</span>
    </div>
    <script>
        manJSEnabled.classList.remove("badge-danger");
        manJSEnabled.classList.add("badge-primary");
        manJSEnabled.innerText="On";
    </script>
</div>
<?="<script>window.jQuery || document.write('<script src=\"".(app::resourceLink("jquery/js/jquery.min.191.js"))."\"><\/script>')</script>\n"?>
<?=app::loadResource("js","jquery/js/jquery.min.191.js")?>
<?app::loadResource("js","tether/js/tether.min.js")?>
<?app::loadResource("js","bootstrap/js/bootstrap.min.js")?>
<?app::loadResource("js","plustest_genesis/igx_request.js")?>

<?php

$annoCorrente = date("Y");
$nomeAutore = "Marco Belli";
$piva = "000000000";
$socialLinks = [
    "instagram" => [
        "url" => "https://www.instagram.com/",
        "icon" => "../media/instagram.png",
        "alt" => "Logo Instagram"
    ],
    "linkedin" => [
        "url" => "https://www.linkedin.com/in/marco-belli-b0626b30b",
        "icon" => "../media/linkedin.png",
        "alt" => "Logo LinkedIn"
    ]
];
?>

<footer>
    <div class="conteiner-footer">
        <div class="conteiner-privacy">
            <p>
                <?php echo $nomeAutore; ?> © <?php echo $annoCorrente; ?> · All rights reserved · P.IVA <?php echo $piva; ?>
                <a href="https://www.iubenda.com/privacy-policy/40502086"
                    class="iubenda-white iubenda-noiframe iubenda-embed"
                    title="Privacy Policy">Privacy Policy</a> & 
                <a href="https://www.iubenda.com/privacy-policy/40502086/cookie-policy"
                    class="iubenda-white iubenda-noiframe iubenda-embed"
                    title="Cookie Policy">Cookie Policy</a>
            </p>
        </div>

        <div class="conteiner-btn-footer">
            <?php foreach ($socialLinks as $social) : ?>
                <a href="<?php echo $social['url']; ?>" target="_blank" title="Go to <?php echo ucfirst($social['alt']); ?>">
                    <img class="icon" src="<?php echo $social['icon']; ?>" alt="<?php echo $social['alt']; ?>">
                </a>
            <?php endforeach; ?>
        </div>
    </div>

    <script type="text/javascript">
        (function(w, d) {
            var loader = function() {
                var s = d.createElement("script"),
                    tag = d.getElementsByTagName("script")[0];
                s.src = "https://cdn.iubenda.com/iubenda.js";
                tag.parentNode.insertBefore(s, tag);
            };
            if (w.addEventListener) {
                w.addEventListener("load", loader, false);
            } else if (w.attachEvent) {
                w.attachEvent("onload", loader);
            } else {
                w.onload = loader;
            }
        })(window, document);
    </script>
</footer>

<?php
class CrapChaPlugin extends AbstractPicoPlugin
{
    /**
     * API version used by this plugin
     *
     * @var int
     */
    const API_VERSION = 3;
    /**
     * Triggered before Pico loads its theme
     *
     * @see Pico::loadTheme()
     * @see DummyPlugin::onThemeLoaded()
     *
     * @param string &$theme name of current theme
     */
    public function onThemeLoading(&$theme)
    {
        // your code
    }

    /**
     * Triggered before Pico reads the contents of the file to serve
     *
     * @see Pico::loadFileContent()
     * @see DummyPlugin::onContentLoaded()
     */
    public function onContentLoading()
    {
    }
    /**
     * Triggered before Pico renders the page
     *
     * @see DummyPlugin::onPageRendered()
     *
     * @param string &$templateName  file name of the template
     * @param array  &$twigVariables template variables
     */
    public function onPageRendering(&$templateName, array &$twigVariables)
    {
        if ($templateName == 'newsletter-subscribe.twig') {
            if ($_POST['h-captcha-response']) {
                $data = array(
                    'secret' => "0x290E9dB6E374804A1632E0d2f2D5AaDDd904987D",
                    'response' => $_POST['h-captcha-response']
                );
                $verify = curl_init();
                curl_setopt($verify, CURLOPT_URL, "https://hcaptcha.com/siteverify");
                curl_setopt($verify, CURLOPT_POST, true);
                curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($data));
                curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($verify);
                $responseData = json_decode($response);
                if (!$responseData->success) {
                    echo "Error";
                    exit;
                } else {
                    file_put_contents('lists/newsletter', $_POST['email'] . "\n", FILE_APPEND);
                    return;
                }
            }
        }
    }
}
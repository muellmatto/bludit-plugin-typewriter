<?php

class typewriter extends Plugin {

    public function init() {
        $this->dbFields = array(
            'timeout'=>'200',
            'spread'=>'0.5'
        );
    }

	public function siteBodyEnd() {
        // returns html code
        $html = '
            <script>
                async function typewrite(el=Null, timeout=300, pause=1000, spread=0.5) {
                    function sleep(ms) {
                        return new Promise(resolve => setTimeout(resolve, ms));
                    }
                    function rnd_timeout(timeout, spread) {
                        var q = (2*spread) * Math.random() + (1 - spread);
                        return Math.floor(timeout * q)
                    }
                    var text = el.innerHTML;
                    el.innerHTML = "";
                    for (char of text) {
                        el.innerHTML += char;
                        await sleep(rnd_timeout(timeout, spread));
                    }
                    await sleep(rnd_timeout(pause, spread));
                }
                for (element of document.getElementsByClassName("typewriter")) {
                    typewrite(element, '.$this->getDbField('timeout').', 0, '.$this->getDbField('spread').');
                }
            </script>
        ';
        return $html;
    }

    public function form() {
        
		global $Language;

        $html = '<div>';
        $html .= '<label>'.$Language->get('timeout-text').'</label>';
        $html .= '<input type="number" name="timeout" min="1" value="';
        $html .= $this->getDbField('timeout');
        $html .= '">';
        $html .= '<label>'.$Language->get('spread-text').'</label>';
        $html .= '<input type="number" name="spread" step="0.01" max="1" min="0" value="';
        $html .= $this->getDbField('spread');
        $html .= '">';
        $html .= '</div>';

        return $html;
    }
}

?>

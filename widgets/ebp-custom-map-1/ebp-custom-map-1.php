<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit;



class Ebp_Custom_Map_1 extends Widget_Base
{

    public function get_name()
    {
        return 'ebp_custom_map_1';
    }

    public function get_title()
    {
        return __('EBP Custom Map 1', 'ebp-custom-widgets');
    }

    public function get_icon()
    {


        // Fallback to default icon if file doesn't exist
        return 'eicon-map-pin';
    }

    public function get_categories()
    {
        return ['ebp-custom-widgets'];
    }

    // Enqueue widget assets
    public function get_script_depends()
    {
        return ['jquery'];
    }

    public function get_style_depends()
    {
        return ['ebp-custom-map-1-style'];
    }


    protected function register_controls()
    {
        // Start content section
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Content', 'ebp-custom-widgets'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        // Add iframe control
        $this->add_control(
            'iframe_code',
            [
                'label' => __('Map Iframe Code', 'ebp-custom-widgets'),
                'type' => Controls_Manager::TEXTAREA,
                'description' => __('Paste your map iframe code here. This will replace the default shortcode.', 'ebp-custom-widgets'),
                'rows' => 10,
                'default' => '',
            ]
        );

        $this->end_controls_section();
    }


    protected function render()
    {
        // Get the iframe code from settings
        $settings = $this->get_settings_for_display();
        $iframe_code = $settings['iframe_code'];
        ?>
<!-- Map  -->
<div class="ebp-custom-map-1">
    <div class="ebp-custom-map-1__map">
        <script>
        // ✅ Official Google Maps Loader — no manual <script> tag
        (g => {
            var h, a, k, p = "The Google Maps JavaScript API",
                c = "google",
                l = "importLibrary",
                q = "__ib__",
                m = document,
                b = window;
            b = b[c] || (b[c] = {});
            var d = b.maps || (b.maps = {}),
                r = new Set(),
                e = new URLSearchParams(),
                u = () =>
                h ||
                (h = new Promise(async (f, n) => {
                    await (a = m.createElement("script"));
                    e.set("libraries", [...r] + "");
                    for (k in g)
                        e.set(k.replace(/[A-Z]/g, t => "_" + t[0].toLowerCase()), g[k]);
                    e.set("callback", c + ".maps." + q);
                    a.src = `https://maps.googleapis.com/maps/api/js?` + e;
                    d[q] = f;
                    a.onerror = () => n(Error(p + " could not load."));
                    a.nonce = m.querySelector("script[nonce]")?.nonce || "";
                    m.head.append(a);
                }));
            d[l] ?
                console.warn(p + " only loads once. Ignoring subsequent calls.") :
                (d[l] = (f, ...n) => (r.add(f), u().then(() => d[l](f, ...n))));
        })({
            key: "AIzaSyAUVnGvh6UxSAl83FOmuOQrwEzCfb_yUwo",
            v: "weekly",
        });

        // ✅ Initialize map
        async function initMap() {
            const {
                Map
            } = await google.maps.importLibrary("maps");
            const {
                AdvancedMarkerElement
            } = await google.maps.importLibrary("marker");

            const position = {
                lat: 53.405399856802056,
                lng: -2.9893491414548494
            };

            const map = new Map(document.getElementById("map1"), {
                center: position,
                zoom: 15,
                mapId: "c17ae3fde52446f8eb1dfa65",
                mapTypeControl: false,
                streetViewControl: false,
                fullscreenControl: false,

            });

            // ✅ Custom SVG marker
            const iconImg = document.createElement("img");
            iconImg.src = "/wp-content/uploads/2025/11/llm-icon.svg";
            iconImg.style.width = "40px";
            iconImg.style.height = "40px";

            new AdvancedMarkerElement({
                map,
                position,
                content: iconImg,
                title: "Our Location",
            });
        }

        // Run once loaded
        window.addEventListener("load", initMap);
        </script>

        <div id="map1" class="map"></div>
    </div>
</div>

<?php
    }
}
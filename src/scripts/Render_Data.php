<?php

class Render_Data {
    private $loader;
    private $twig;
    private $config;
    private $output;
    private $base_tmp;
    private $page;
    private $uri;

    public function __construct($base_tmp, $page, $uri = '/') {
        Twig_Autoloader::register();
        $this->loader = new Twig_Loader_Filesystem('templates');
        $this->twig = new Twig_Environment($this->loader, array(
            'cache'       => 'compilation_cache',
            'auto_reload' => true
        ));
        $this->base_tmp = $base_tmp;

        if (isset($page)) {
            $this->page = $page;
        } else {
            $this->page = 'base';
        }

        if (isset($uri)) {
            $this->uri = $uri;
        } else {
            $this->uri = '/';
        }
    }

    private function get_file_data($path) {
        $path = $_SERVER['DOCUMENT_ROOT'] . '/admin/' . $path;
        
        $superPath = $_SERVER['DOCUMENT_ROOT'] . '/admin/superRoot.json';
        $superJson = json_decode(file_get_contents($superPath), true);

        if (file_exists($path)) {
            $json = file_get_contents($path);
            $uri['__system']['uri']['data'] = $this->uri;
            return array_merge($uri, $superJson, json_decode($json, true));
        } else {
            echo "<div style='font-size: 14px; '>Файл <span style='background: #a00000;color: #fff;padding: 5px;'>".$path."</span> не существует</div>";
            return false;
        }
    }

    private function generate_data($data) {
        $new_data = [];

        if (array_key_exists('json', $data)) {
            if ($this->get_file_data($data['json'])) {
                $new_data = $this->generate_data($this->get_file_data($data['json']));
            }
        } else if (array_key_exists('data', $data)) {
            $new_data = $this->generate_data($data['data']);
        } else {
            foreach ($data as $key => $value) {
                if (array_key_exists('data', $value)) {
                    $new_data[$key] = $value['data'];
                } else {
                    $new_data[$key] = $this->generate_data($value);
                }
            }
        }

        return $new_data;
    }

    public function render($config_file) {
        if ($config_file == 'MAIN') {
            $this->config = $this->get_file_data($this->page . '.json');
        } else {
            if ($this->get_file_data($config_file)) {
                $this->config = $this->get_file_data($config_file);
            }
        }

        foreach ($this->config as $key => $val) {
            if ($key == '__modules') {
                foreach ($this->config['__modules'] as $module => $module_data) {
                    $this->output[$module] = $this->generate_data($module_data);
                }
            } else {
                $this->output[$key] = $this->generate_data($val);
            }
        }

        if ($config_file !== 'MAIN') {
            $this->output = [
                "__scope" => $this->output
            ];
        }

        echo $this->twig->render($this->base_tmp, $this->output);
    }
}

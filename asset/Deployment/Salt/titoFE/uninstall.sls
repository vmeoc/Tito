{% import_yaml "./conf.yaml" as conf %}

remove pkgs: 
  pkg.removed:
    - pkgs:
      - httpd
      - php
      - php-mysql

{{ conf.php.ini_file }}:
  file.absent

{{ conf.code.destination }}:
  file.absent

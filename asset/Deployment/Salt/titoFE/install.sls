{% import_yaml "./conf.yaml" as conf %}

{% set SQLSERVER = 'xxx' %}

install all nec packages:
 pkg.installed:
    - pkgs:
      - git
      - httpd
      - php
      - php-mysql

HTTPD Conf modification to load php module and talk to the SQL server:
  file.append:
    - name: {{ conf.httpd.conf_file }}
    - text:
      - LoadModule php5_module modules/libphp5.so
      - <IfModule env_module>
      -   SetEnv TITO-SQL {{ SQLSERVER }}
      - </IfModule>

PHP INI modification to set the timezone:
  file.append:
    - name: {{ conf.php.ini_file }}
    - text:
      - date.timezone = "Europe/Paris"

restarting Apache:
  service.running:
    - name: httpd
    - enable: True
    - require:
      - HTTPD Conf modification to load php module and talk to the SQL server
      - PHP INI modification to set the timezone
    - watch:
      - HTTPD Conf modification to load php module and talk to the SQL server
      - PHP INI modification to set the timezone

Installing Tito source code:
  git.latest:
    - name: {{ conf.code.git_repo }}
    - target: {{ conf.code.destination }}
    - rev: {{ conf.code.version }}
    - force_reset: True

#Variables:
{% set HTMLPATH = '/var/www/html' %}
{% set GITREPO = 'https://github.com/vmeoc/Tito/' %}
{% set HTTPDCONF = '/etc/httpd/conf/httpd.conf' %}
{% set CODEVERSION = 'V1.5' %}
{% set PHPINIFILE = '/etc/php.ini' %}
#A modifier
{% set SQLSERVER = 'xxx' %}

install all nec packages:
 pkg.installed:
    - pkgs: 
      - git
      - httpd
      - php
      - php-mysql

{{ HTTPDCONF }}:
  file.managed

HTTPD Conf modification to load php module and talk to the SQL server:
  file.append:
    - name: {{ HTTPDCONF }}
    - text: 
      - LoadModule php5_module modules/libphp5.so
      - <IfModule env_module>
      -   SetEnv TITO-SQL {{ SQLSERVER }}
      - </IfModule>

PHP INI modification to set the timezone:
  file.append:
    - name: {{ PHPINIFILE }}
    - text: 
      - date.timezone = "Europe/Paris"

restarting Apache:
  service.running:
    - name: httpd
    - enable: True
    - watch:
      - file: {{ HTTPDCONF }}
    - require:
      - HTTPD Conf modification to load php module and talk to the SQL server

Installing Tito source code:
  git.latest:
    - name: {{ GITREPO }}
    - target: {{ HTMLPATH }}
    - rev: {{ CODEVERSION }}
    - force_reset: True

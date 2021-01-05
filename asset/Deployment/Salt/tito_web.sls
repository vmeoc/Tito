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
    - names: 
      - git
      - httpd
      - php
      - php-mysql

File to manage:
  file.managed:
    - name: {{ HTTPDCONF }}
  
restarting Apache:
  service.running:
    - name: httpd
    - enable: True
    - watch:
      - file: {{ HTTPDCONF }}

Installing Tito source code:
  git.latest:
    - name: {{ GITREPO }}
    - target: {{ HTMLPATH }}
    - rev: {{ CODEVERSION }}
    - force_reset: True

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

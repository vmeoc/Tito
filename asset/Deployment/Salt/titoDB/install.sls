{% import_yaml "./conf.yaml" as conf %}

install all nec packages:
 pkg.installed:
    - names: 
      - mariadb-server
      - mariadb
      - MySQL-python

running MySQL:
  service.running:
    - name: mariadb
    - enable: True

{{ conf.mysql.user }}:
  mysql_user.present:
    - host: localhost
    - password: {{ conf.mysql.password }}

DB Setup:
  mysql_database.present:
    - name: {{ conf.DB.name }}
    - connection_host: localhost
    - connection_user: {{ conf.mysql.user }}
    - connection_pass: {{ conf.mysql.password }}

Grant privileges:
  mysql_query.run:
    - database: {{ conf.DB.name }}
    - query: "grant all privileges on *.* to '{{ conf.mysql.user }}'@'%' identified by '{{ conf.mysql.password }}' with grant option;"
    - connection_host: localhost
    - connection_user: {{ conf.mysql.user }}
    - connection_pass: {{ conf.mysql.password }}

Table setup:
  mysql_query.run:
    - database: {{ conf.DB.name }}
    - query: "CREATE TABLE {{ conf.DB.table }} (id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, home VARCHAR(50) NOT NULL, work VARCHAR(50) NOT NULL, hour_home_departure VARCHAR(50) NOT NULL, hour_work_departure VARCHAR(50) NOT NULL);"
    - connection_host: localhost
    - connection_user: {{ conf.mysql.user }}
    - connection_pass: {{ conf.mysql.password }}

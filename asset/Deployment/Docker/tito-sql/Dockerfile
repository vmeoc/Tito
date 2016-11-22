#Created by Vincent Meoc
# Create the Tito Back end

FROM mysql:5.7
ENV MYSQL_ROOT_PASSWORD: Tito2016
ENV MYSQL_DATABASE: TitoDB
ENV MYSQL_USER: root
ENV MYSQL_PASSWORD: Tito2016

ADD asset/Deployment/Docker/tito-sql/db_name.sql /tmp/
RUN mysql -uroot -pTito2016 < /tmp/db_name.sql
FROM haproxy:2.3.10-alpine

ADD ./haproxy/*.cfg /usr/local/etc/haproxy/
#ADD ./docker/haproxy/*.pem /etc/cert/
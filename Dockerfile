#

FROM php:8.4-apache as builder

CMD ["apache2-foreground"]

FROM builder as dev-envs

RUN <<EOF
apt-get update
apt-get install -y --no-install-recommends git
EOF

RUN <<EOF
useradd -s /bin/bash -m vscode
groupadd docker
usermod -aG docker vscode
EOF

COPY apache2.conf /etc/apache2/apache2.conf

COPY --from=gloursdocker/docker / /

CMD ["apache2-foreground"]
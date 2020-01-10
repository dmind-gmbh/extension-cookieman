# adds `mkcert` to the selenium-node-* containers
ARG BASE_IMAGE
FROM $BASE_IMAGE

MAINTAINER Jonas Eberle <projekt-cookieman@dmind.de>

RUN sudo apt-get update \
    && sudo apt-get -y -o Dpkg::Options::="--force-confnew" install libnss3-tools git build-essential curl file git \
    && sudo rm -rf /var/lib/apt/lists/*
RUN sh -c "$(curl -fsSL https://raw.githubusercontent.com/Linuxbrew/install/master/install.sh)"
ENV PATH="/home/linuxbrew/.linuxbrew/bin:/home/linuxbrew/.linuxbrew/Homebrew/Library/Homebrew/vendor/portable-ruby/current/bin:${PATH}"
RUN brew install mkcert nss

CMD ["/bin/sh", "-l", "-c", "\
mkcert -install \
; /opt/bin/entry_point.sh\
"]

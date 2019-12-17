# installs and runs `mkcert -install`
ARG BASE_IMAGE
FROM $BASE_IMAGE

RUN sudo apt-get update
RUN sudo apt-get -y -o Dpkg::Options::="--force-confnew" install libnss3-tools git build-essential curl file git
RUN sh -c "$(curl -fsSL https://raw.githubusercontent.com/Linuxbrew/install/master/install.sh)"
ENV PATH="/home/linuxbrew/.linuxbrew/bin:/home/linuxbrew/.linuxbrew/Homebrew/Library/Homebrew/vendor/portable-ruby/current/bin:${PATH}"
RUN brew install mkcert nss
RUN mkcert -install

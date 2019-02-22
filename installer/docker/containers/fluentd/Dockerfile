#fluentd / Dockerfile 
FROM fluent/fluentd:v1.3-debian
RUN gem sources --add http://gems.ruby-china.com/ --remove https://rubygems.org/
RUN gem sources -l

# 替换国内源
RUN sed -i 's/deb.debian.org/mirrors.ustc.edu.cn/g' /etc/apt/sources.list

RUN apt-get update && apt-get install -y ruby-dev  make gcc g++ libc-dev
RUN gem install fluent-plugin-mongo fluent-plugin-grok-parser
USER root
# Add a non-root user to prevent files being created with root permissions on host machine.
ARG PUID=1000
ENV PUID ${PUID}
ARG PGID=1000
ENV PGID ${PGID}

# always run apt update when start and after add new source list, then clean up at end.
RUN usermod -u ${PUID} fluent && groupmod -g ${PGID} fluent
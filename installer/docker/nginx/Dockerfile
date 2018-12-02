FROM nginx

LABEL maintainer="tianshuo feng <550610606@qq.com>"
USER root
# Add a non-root user to prevent files being created with root permissions on host machine.
ARG PUID=1000
ENV PUID ${PUID}
ARG PGID=1000
ENV PGID ${PGID}

# always run apt update when start and after add new source list, then clean up at end.
RUN groupadd -g ${PGID} docker && \
    useradd -u ${PUID} -g docker -m docker && \
    usermod -p "*" docker
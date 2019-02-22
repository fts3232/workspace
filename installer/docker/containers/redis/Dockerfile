FROM redis:latest

LABEL maintainer="tianshuo Feng <550610606@qq.com>"

## For security settings uncomment, make the dir, copy conf, and also start with the conf, to use it
#RUN mkdir -p /usr/local/etc/redis
#COPY redis.conf /usr/local/etc/redis/redis.conf

USER root
# Add a non-root user to prevent files being created with root permissions on host machine.
ARG PUID=1000
ENV PUID ${PUID}
ARG PGID=1000
ENV PGID ${PGID}

# always run apt update when start and after add new source list, then clean up at end.
RUN usermod -u ${PUID} redis && groupmod -g ${PGID} redis

EXPOSE 6379
CMD ["redis-server","/etc/redis/redis.conf","--appendonly yes"]

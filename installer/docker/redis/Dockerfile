FROM redis:latest

LABEL maintainer="tianshuo Feng <550610606@qq.com>"

## For security settings uncomment, make the dir, copy conf, and also start with the conf, to use it
#RUN mkdir -p /usr/local/etc/redis
#COPY redis.conf /usr/local/etc/redis/redis.conf
RUN mkdir /var/log/redis
RUN touch /var/log/redis/redis.log

EXPOSE 6379
CMD ["redis-server"]

FROM mongo:latest

LABEL maintainer="tianshuo Feng <550610606@qq.com>"

#COPY mongo.conf /usr/local/etc/mongo/mongo.conf
USER root
# Add a non-root user to prevent files being created with root permissions on host machine.
ARG PUID=1000
ENV PUID ${PUID}
ARG PGID=1000
ENV PGID ${PGID}

# always run apt update when start and after add new source list, then clean up at end.
RUN usermod -u ${PUID} mongodb && groupmod -g ${PGID} mongodb

COPY ./mongo-entrypoint/createUser.js /docker-entrypoint-initdb.d/

CMD ["mongod","--logappend","--logpath=/var/log/mongodb/mongo.log"]

EXPOSE 27017


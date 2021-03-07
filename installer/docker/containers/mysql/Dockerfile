FROM mysql
ENV MYSQL_ROOT_PASSWORD 'tian.32'
USER root
# Add a non-root user to prevent files being created with root permissions on host machine.
ARG PUID=1000
ENV PUID ${PUID}
ARG PGID=1000
ENV PGID ${PGID}

# always run apt update when start and after add new source list, then clean up at end.
RUN usermod -u ${PUID} mysql && groupmod -g ${PGID} mysql

CMD ["mysqld"]

EXPOSE 3306
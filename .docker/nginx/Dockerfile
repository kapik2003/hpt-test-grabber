FROM nginx:1.19

ARG WEB_USER
ARG WEB_GROUP
ARG WEB_ROOT_DIR
ARG WEB_LOG_DIR
ARG WEB_SITE_DIR

RUN mkdir -p ${WEB_SITE_DIR}
RUN chown -R ${WEB_USER}:${WEB_GROUP} ${WEB_SITE_DIR}
RUN chmod -R 750 ${WEB_SITE_DIR}
RUN chmod -R g+rwX ${WEB_SITE_DIR}
RUN chmod g+s ${WEB_SITE_DIR}

RUN mkdir -p ${WEB_ROOT_DIR}/sites-enabled
COPY general.conf ${WEB_ROOT_DIR}/nginx.conf
COPY fastcgi-default.conf ${WEB_ROOT_DIR}/sites-available/default.conf
RUN ln -s ${WEB_ROOT_DIR}/sites-available/default.conf ${WEB_ROOT_DIR}/sites-enabled/

WORKDIR ${WEB_SITE_DIR}
CMD ["nginx", "-g", "daemon off;"]

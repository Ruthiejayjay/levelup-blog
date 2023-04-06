FROM node:16.17.0-alpine

WORKDIR /home/node/app

COPY --chown=node:node package*.json .
RUN npm install

COPY --chown=node:node . .
RUN chown -R node /home/node/app

USER node
CMD ["npm", "run", "dev"]

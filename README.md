# Farm Fusion Docker Setup

This repository contains a Docker-based environment for the Farm Fusion project, which includes:

- Laravel API (Backend)
- Vue.js App (Frontend)
- PostgreSQL Database
- Nginx (Reverse Proxy)

## Prerequisites

- Docker and Docker Compose installed on your system
- Git (for cloning the repository)

## Project Structure

```
farm-fusion/
├── docker/
│   ├── nginx/
│   │   └── conf.d/
│   │       └── default.conf
│   └── postgres/
│       └── init/
│           └── 01-init.sql
├── farm-fusion-api/
│   ├── dev.Dockerfile
│   └── prod.Dockerfile
├── farm-fusion-vue/
│   ├── dev.Dockerfile
│   └── prod.Dockerfile
├── docker-compose.yml
└── .env.docker
```

## Getting Started

### Development Environment

1. Clone the repository:
   ```bash
   git clone <repository-url>
   cd farm-fusion
   ```

2. Copy the environment file:
   ```bash
   cp .env.docker .env
   ```

3. Start the development environment:
   ```bash
   docker-compose up -d
   ```

4. Access the applications:
   - Laravel API: http://localhost/api
   - Vue.js App: http://localhost
   - Database: localhost:5432 (use a PostgreSQL client)

### Production Environment

1. Set the environment to production in `.env`:
   ```
   DOCKER_ENV=prod
   APP_ENV=production
   NODE_ENV=production
   ```

2. Start the production environment:
   ```bash
   docker-compose up -d
   ```

## Configuration

### Environment Variables

The `.env` file contains environment variables for configuring the Docker setup:

- `DOCKER_ENV`: Set to `dev` for development or `prod` for production
- `APP_ENV`: Laravel environment (`local` or `production`)
- `NODE_ENV`: Node.js environment (`development` or `production`)
- `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`: PostgreSQL database configuration
- `NGINX_PORT`, `NGINX_SSL_PORT`: Nginx port configuration
- `VITE_API_URL`: API URL for the frontend

### SSL Configuration

For production, you should enable SSL by:

1. Placing your SSL certificates in `docker/nginx/ssl/`
2. Uncommenting the HTTPS server block in `docker/nginx/conf.d/default.conf`
3. Uncommenting the HTTP to HTTPS redirect in the HTTP server block

## Development Workflow

- The Laravel API code is mounted as a volume in development mode, allowing for live code changes
- The Vue.js app uses Vite's hot module replacement for live frontend updates
- Database data is persisted in a Docker volume

## Maintenance

### Viewing Logs

```bash
# View all logs
docker-compose logs

# View logs for a specific service
docker-compose logs api
docker-compose logs frontend
docker-compose logs nginx
docker-compose logs db
```

### Stopping the Environment

```bash
docker-compose down
```

### Rebuilding Containers

```bash
docker-compose build
```

## Troubleshooting

- If you encounter permission issues, ensure that the user in the containers has the correct permissions
- For database connection issues, check that the database service is running and the credentials are correct
- For Nginx routing issues, check the Nginx configuration and logs

## License

[Your License] 
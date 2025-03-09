#!/bin/bash

# Print colorful messages
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
RED='\033[0;31m'
NC='\033[0m' # No Color

# Function to display help
show_help() {
    echo -e "${BLUE}=== Farm Fusion Maintenance Script ===${NC}"
    echo -e "Usage: ./maintenance.sh [command]"
    echo -e ""
    echo -e "Commands:"
    echo -e "  ${GREEN}logs${NC}             - Show logs from all containers"
    echo -e "  ${GREEN}logs [service]${NC}   - Show logs from a specific service (api, frontend, nginx, db)"
    echo -e "  ${GREEN}restart${NC}          - Restart all containers"
    echo -e "  ${GREEN}restart [service]${NC} - Restart a specific service"
    echo -e "  ${GREEN}rebuild${NC}          - Rebuild all containers"
    echo -e "  ${GREEN}migrate${NC}          - Run Laravel migrations"
    echo -e "  ${GREEN}seed${NC}             - Run Laravel seeders"
    echo -e "  ${GREEN}composer [cmd]${NC}   - Run composer command in the API container"
    echo -e "  ${GREEN}npm [cmd]${NC}        - Run npm command in the frontend container"
    echo -e "  ${GREEN}artisan [cmd]${NC}    - Run artisan command in the API container"
    echo -e "  ${GREEN}bash [service]${NC}   - Open bash shell in a container"
    echo -e "  ${GREEN}status${NC}           - Show status of all containers"
    echo -e "  ${GREEN}help${NC}             - Show this help message"
    echo -e ""
}

# Check if Docker is running
if ! docker info > /dev/null 2>&1; then
    echo -e "${RED}Docker is not running. Please start Docker and try again.${NC}"
    exit 1
fi

# Check if Docker Compose is installed
if ! command -v docker-compose &> /dev/null; then
    echo -e "${RED}Docker Compose is not installed. Please install Docker Compose and try again.${NC}"
    exit 1
fi

# Check if containers are running
check_containers() {
    if [ "$(docker-compose ps -q | wc -l)" -eq 0 ]; then
        echo -e "${YELLOW}No containers are running. Start the environment first with ./start.sh${NC}"
        exit 1
    fi
}

# Handle commands
case "$1" in
    logs)
        if [ -z "$2" ]; then
            docker-compose logs -f
        else
            docker-compose logs -f "$2"
        fi
        ;;
    restart)
        if [ -z "$2" ]; then
            echo -e "${BLUE}Restarting all containers...${NC}"
            docker-compose restart
        else
            echo -e "${BLUE}Restarting $2 container...${NC}"
            docker-compose restart "$2"
        fi
        ;;
    rebuild)
        echo -e "${BLUE}Rebuilding all containers...${NC}"
        docker-compose down
        docker-compose build
        docker-compose up -d
        ;;
    migrate)
        check_containers
        echo -e "${BLUE}Running Laravel migrations...${NC}"
        docker-compose exec api php artisan migrate
        ;;
    seed)
        check_containers
        echo -e "${BLUE}Running Laravel seeders...${NC}"
        docker-compose exec api php artisan db:seed
        ;;
    composer)
        check_containers
        if [ -z "$2" ]; then
            echo -e "${YELLOW}Please specify a composer command.${NC}"
            exit 1
        fi
        shift
        docker-compose exec api composer "$@"
        ;;
    npm)
        check_containers
        if [ -z "$2" ]; then
            echo -e "${YELLOW}Please specify an npm command.${NC}"
            exit 1
        fi
        shift
        docker-compose exec frontend npm "$@"
        ;;
    artisan)
        check_containers
        if [ -z "$2" ]; then
            echo -e "${YELLOW}Please specify an artisan command.${NC}"
            exit 1
        fi
        shift
        docker-compose exec api php artisan "$@"
        ;;
    bash)
        check_containers
        if [ -z "$2" ]; then
            echo -e "${YELLOW}Please specify a service (api, frontend, nginx, db).${NC}"
            exit 1
        fi
        docker-compose exec "$2" bash || docker-compose exec "$2" sh
        ;;
    status)
        echo -e "${BLUE}Container status:${NC}"
        docker-compose ps
        ;;
    help|*)
        show_help
        ;;
esac 
# CV Generator Docker Setup

A multi-container application for generating CVs with AI assistance using Gemini API.

## Architecture

- **PHP Application**: Bootstrap-based UI with integrated backend for CV generation and management
- **MySQL Database**: Persistent data storage
- **PHPMyAdmin**: Database management interface

## Prerequisites

- Docker Desktop installed and running
- Gemini API key from Google
- Git (for cloning the repository)

## Quick Start

### 1. Clone the Repository
```bash
git clone <your-repo-url>
cd cv_gen
```

### 2. Set Up Environment Variables
Create a `.env` file in the root directory:
```bash
GEMINI_API_KEY=your_gemini_api_key_here
```

### 3. Build and Start Containers
```bash
docker-compose up -d --build
```

This will:
- Build and start the PHP application on `http://localhost:8080`
- Start MySQL database
- Start PHPMyAdmin on `http://localhost:8081`

### 4. Access the Services

| Service | URL | Credentials |
|---------|-----|-------------|
| CV Generator (PHP) | http://localhost:8080 | - |
| PHPMyAdmin | http://localhost:8081 | Username: `cvgen_user`, Password: `cvgen_password` |
| Database | localhost:3306 | User: `cvgen_user`, Password: `cvgen_password` |

## Project Structure

```
cv_gen/
├── docker-compose.yml
├── .env
├── src/
│   └── php/          # PHP application (Bootstrap-based UI + backend)
├── docker/
│   ├── php/
│   │   ├── Dockerfile
│   │   └── php.ini
│   └── db/
│       └── init.sql   # Database initialization script
```

## Common Commands

### Stop Containers
```bash
docker-compose down
```

### View Logs
```bash
docker-compose logs -f [service_name]
```

### Rebuild Services
```bash
docker-compose up -d --build
```

### Access Container Shell
```bash
# PHP container
docker-compose exec app bash

# Database container
docker-compose exec db bash
```

## GitHub Workflow Guide

### Creating an Issue

#### Via GitHub UI
1. Navigate to the **Issues** tab on the repository
2. Click **New Issue**
3. Add a descriptive **Title** (e.g., "Add user authentication")
4. Write a detailed **Description** including:
   - What needs to be done
   - Why it's needed
   - Acceptance criteria
5. Assign labels (e.g., `feature`, `bug`, `enhancement`)
6. Click **Submit new issue**

#### Via Command Line
```bash
# View existing issues
gh issue list

# Create a new issue
gh issue create --title "Add user authentication" --body "Implement login functionality for user accounts"
```

### Creating a Branch for the Issue

#### Via VSCode
1. Open the **Source Control** panel (Ctrl+Shift+G)
2. Click the **...** menu and select **Branch > Create Branch**
3. Name it based on the issue: `feature/auth-system` or `fix/login-bug`
4. Make sure it's based on `main`

#### Via Command Line
```bash
# Create and checkout a new branch
git checkout -b feature/auth-system

# Push the branch to GitHub
git push -u origin feature/auth-system
```

### Rebasing in VSCode

#### Interactive Rebase
1. Open **Source Control** (Ctrl+Shift+G)
2. Click **...** menu → **Branch** → **Rebase Branch**
3. Select the branch to rebase onto (usually `main`)
4. VSCode will apply your commits on top of the latest main
5. If conflicts occur, resolve them and continue

#### Via Command Line
```bash
# Rebase current branch onto main
git rebase main

# If conflicts occur, after resolving them:
git add .
git rebase --continue

# If you need to abort the rebase
git rebase --abort
```

### Creating a Pull Request (Rebase and Merge)

#### Via GitHub UI
1. Push your branch to GitHub
2. Navigate to the **Pull requests** tab
3. Click **New pull request**
4. Select your branch as the source, `main` as the target
5. Add a title and description (reference the issue: "Closes #123")
6. Request reviewers
7. Click **Create pull request**

#### Rebase and Merge
1. After approval, click **Rebase and merge** (not "Squash and merge")
2. This applies your commits on top of main without creating a merge commit
3. Click **Confirm rebase and merge**
4. The branch is automatically deleted

#### Via Command Line
```bash
# Ensure your branch is up to date with main
git fetch origin
git rebase origin/main

# Force push if needed (only do this on your own branch!)
git push -f origin feature/auth-system

# After PR is approved, merge locally
git checkout main
git pull origin main
git rebase feature/auth-system  # or git merge --no-ff feature/auth-system
git push origin main

# Delete the branch locally and remotely
git branch -d feature/auth-system
git push origin --delete feature/auth-system
```

### Closing the Issue

#### Via GitHub UI
1. Go to your **Pull Request**
2. In the **Description**, add: `Closes #123` (replace 123 with issue number)
3. When the PR is merged, the issue auto-closes
4. Alternatively, go to the **Issue** and click **Close issue**

#### Via Command Line
```bash
# When creating a commit, reference the issue
git commit -m "Implement auth system - Closes #123"

# After merging, you can close via CLI
gh issue close 123
```

### Best Practices
- Always create an issue before starting work
- Use descriptive branch names: `feature/`, `fix/`, `docs/`
- Keep commits atomic and focused
- Rebase and merge to keep a clean history
- Link PRs to issues using "Closes #123"
- Get code review before merging

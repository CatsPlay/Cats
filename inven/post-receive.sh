#!/bin/sh

# Chemin vers le répertoire de déploiement (à personnaliser)
DEPLOY_DIR="/home/mon-compte/www/mon-projet"

# Branche à déployer (à personnaliser)
BRANCH="production"

while read oldrev newrev refname
do
    # Vérifie si la branche poussée est celle que vous souhaitez déployer
    if [ "$refname" = "refs/heads/$BRANCH" ]; then
        echo "Déploiement de la branche $BRANCH..."
        cd $DEPLOY_DIR || exit
        unset GIT_DIR
        git pull origin $BRANCH
        echo "Déploiement terminé !"
    fi
done

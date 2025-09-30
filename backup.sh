 #!/bin/bash

  # Script de sauvegarde Cerfaos
  echo "🔄 Début de la sauvegarde Cerfaos"

  # Variables
  BACKUP_DIR="$HOME/backups"
  SITE_DIR="$HOME/domains/cerfaos.fr/public_html"
  DATE=$(date +"%Y%m%d_%H%M%S")
  BACKUP_NAME="cerfaos_backup_$DATE"

  # Créer le dossier de sauvegarde
  mkdir -p $BACKUP_DIR

  echo "📦 Création de l'archive..."

  # Aller dans le site et créer l'archive
  cd $SITE_DIR
  tar -czf "$BACKUP_DIR/$BACKUP_NAME.tar.gz" \
      --exclude='node_modules' \
      --exclude='vendor' \
      --exclude='storage/logs/*' \
      .

  echo "✅ Sauvegarde terminée !"
  echo "📁 Fichier : $BACKUP_NAME.tar.gz"
  echo "📍 Localisation : $BACKUP_DIR"

  # Afficher la taille
  du -h "$BACKUP_DIR/$BACKUP_NAME.tar.gz"


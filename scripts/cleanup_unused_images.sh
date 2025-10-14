#!/bin/bash
# ============================================
# Virical - Cleanup Unused Images Script
# ============================================
# This script removes unused images from wp-content/uploads/2025/09/
# to reduce deployment package size from 2.4GB to ~500MB
#
# Usage: ./cleanup_unused_images.sh [--backup] [--dry-run]
#

set -e

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Configuration
UPLOAD_DIR="production-deploy/wordpress/wp-content/uploads/2025/09"
UNUSED_LIST="/tmp/unused_images.txt"
BACKUP_DIR="unused_images_archive/2025/09"
DRY_RUN=false
CREATE_BACKUP=false

# Parse arguments
for arg in "$@"; do
  case $arg in
    --dry-run)
      DRY_RUN=true
      shift
      ;;
    --backup)
      CREATE_BACKUP=true
      shift
      ;;
    --help)
      echo "Usage: ./cleanup_unused_images.sh [--backup] [--dry-run]"
      echo ""
      echo "Options:"
      echo "  --backup    Create archive of unused images before deletion"
      echo "  --dry-run   Show what would be deleted without actually deleting"
      echo "  --help      Show this help message"
      exit 0
      ;;
  esac
done

echo ""
echo -e "${BLUE}============================================${NC}"
echo -e "${BLUE}VIRICAL - CLEANUP UNUSED IMAGES${NC}"
echo -e "${BLUE}============================================${NC}"
echo ""

# Check if unused images list exists
if [ ! -f "$UNUSED_LIST" ]; then
  echo -e "${RED}❌ Error: Unused images list not found!${NC}"
  echo -e "${YELLOW}Please run the analysis first.${NC}"
  exit 1
fi

# Check if upload directory exists
if [ ! -d "$UPLOAD_DIR" ]; then
  echo -e "${RED}❌ Error: Upload directory not found!${NC}"
  echo -e "${YELLOW}Expected: $UPLOAD_DIR${NC}"
  exit 1
fi

# Count unused images
UNUSED_COUNT=$(wc -l < "$UNUSED_LIST")

# Calculate total size
total_size=0
while IFS= read -r file; do
  if [ -f "$UPLOAD_DIR/$file" ]; then
    size=$(stat -c%s "$UPLOAD_DIR/$file" 2>/dev/null || echo 0)
    total_size=$((total_size + size))
  fi
done < "$UNUSED_LIST"

total_size_human=$(numfmt --to=iec-i --suffix=B $total_size)

echo -e "${YELLOW}📊 Analysis Summary:${NC}"
echo "   Unused images: $UNUSED_COUNT files"
echo "   Total size: $total_size_human"
echo ""

if [ "$DRY_RUN" = true ]; then
  echo -e "${BLUE}🔍 DRY RUN MODE - No files will be deleted${NC}"
  echo ""
  echo "Files that would be deleted:"
  head -20 "$UNUSED_LIST"
  if [ $UNUSED_COUNT -gt 20 ]; then
    echo "... and $((UNUSED_COUNT - 20)) more files"
  fi
  echo ""
  echo -e "${GREEN}✅ Dry run complete. Run without --dry-run to actually delete.${NC}"
  exit 0
fi

# Confirmation
echo -e "${YELLOW}⚠️  WARNING: This will delete $UNUSED_COUNT files ($total_size_human)${NC}"
echo ""
if [ "$CREATE_BACKUP" = true ]; then
  echo -e "${GREEN}✅ Backup will be created in: $BACKUP_DIR${NC}"
else
  echo -e "${RED}⚠️  No backup will be created (use --backup to create archive)${NC}"
fi
echo ""
read -p "Are you sure you want to continue? (yes/no): " confirm

if [ "$confirm" != "yes" ]; then
  echo -e "${YELLOW}❌ Operation cancelled.${NC}"
  exit 0
fi

echo ""

# Create backup if requested
if [ "$CREATE_BACKUP" = true ]; then
  echo -e "${BLUE}📦 Creating backup...${NC}"
  mkdir -p "$BACKUP_DIR"
  
  count=0
  while IFS= read -r file; do
    if [ -f "$UPLOAD_DIR/$file" ]; then
      cp "$UPLOAD_DIR/$file" "$BACKUP_DIR/"
      count=$((count + 1))
      echo -ne "\r   Backed up: $count/$UNUSED_COUNT files"
    fi
  done < "$UNUSED_LIST"
  
  echo ""
  backup_size=$(du -sh "$BACKUP_DIR" | cut -f1)
  echo -e "${GREEN}✅ Backup created: $BACKUP_DIR ($backup_size)${NC}"
  echo ""
fi

# Delete unused images
echo -e "${BLUE}🗑️  Deleting unused images...${NC}"

deleted=0
failed=0

while IFS= read -r file; do
  if [ -f "$UPLOAD_DIR/$file" ]; then
    if rm "$UPLOAD_DIR/$file" 2>/dev/null; then
      deleted=$((deleted + 1))
    else
      failed=$((failed + 1))
      echo -e "${RED}   Failed to delete: $file${NC}"
    fi
    echo -ne "\r   Progress: $deleted/$UNUSED_COUNT deleted"
  fi
done < "$UNUSED_LIST"

echo ""
echo ""

# Summary
echo -e "${BLUE}============================================${NC}"
echo -e "${BLUE}CLEANUP SUMMARY${NC}"
echo -e "${BLUE}============================================${NC}"
echo ""
echo -e "${GREEN}✅ Successfully deleted: $deleted files${NC}"
if [ $failed -gt 0 ]; then
  echo -e "${RED}❌ Failed to delete: $failed files${NC}"
fi
echo ""

# Calculate new size
new_size=$(du -sh "$UPLOAD_DIR" | cut -f1)
echo "New upload directory size: $new_size"
echo "Space saved: $total_size_human"
echo ""

# Verify
echo -e "${BLUE}🔍 Verification:${NC}"
remaining=$(find "$UPLOAD_DIR" -type f | wc -l)
echo "   Remaining files in uploads: $remaining"
echo ""

if [ "$CREATE_BACKUP" = true ]; then
  echo -e "${YELLOW}📦 Backup location: $BACKUP_DIR${NC}"
  echo -e "${YELLOW}   Keep this backup for at least 1 week before deleting.${NC}"
  echo ""
fi

echo -e "${GREEN}✅ CLEANUP COMPLETED SUCCESSFULLY!${NC}"
echo ""
echo "Next steps:"
echo "1. Verify package size: du -sh production-deploy/"
echo "2. Test website after deployment"
echo "3. Monitor for 24 hours"
if [ "$CREATE_BACKUP" = true ]; then
  echo "4. Delete backup after 1 week if no issues"
fi
echo ""

exit 0

#!/bin/bash

CUR_PWD=`pwd`
DIST_MASTER="/usr/local/dev_swan/web"
SF_DIR="$CUR_PWD/lib/sf"
DIST_SF="$DIST_MASTER/lib/sf"
SWAN_DOCS_DIR="$CUR_PWD/data/swan_docs"
DIST_SWAN_DOCS="$DIST_MASTER/data/swan_docs"

CONFIGURE_CMD="/usr/local/dev_swan/configure -d "


# 生成主仓库的 Makefile
CMD="$CONFIGURE_CMD $DIST_MASTER"
echo $CMD
eval $CMD

# 生成 SF1 仓库的 Makefile
cd $SF_DIR
CMD="$CONFIGURE_CMD $DIST_SF"
echo $CMD
eval $CMD

# 生成 SWAN_DOCS 仓库的 Makefile
cd $SWAN_DOCS_DIR
CMD="$CONFIGURE_CMD $DIST_SWAN_DOCS"
echo $CMD
eval $CMD

cd $CUR_PWD
make install

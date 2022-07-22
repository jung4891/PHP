/*
 * This program is copyright Alec Muffett 1993. The author disclaims all
 * responsibility or liability with respect to it's usage or its effect
 * upon hardware or computer systems, and maintains copyright as set out
 * in the "LICENCE" document which accompanies distributions of Crack v4.0
 * and upwards.
 */

static char vers_id[] = "fascist.c : v2.3p3 Alec Muffett 14 dec 1997";

#include "config.h"
#include <sys/types.h>
#include <errno.h>
#include <limits.h>
#include <pwd.h>
#include <stdlib.h>
#include <string.h>
#ifdef HAVE_UNISTD_H
#include <unistd.h>
#endif

#if defined(HAVE_INTTYPES_H)
#include <inttypes.h>
#else
#if defined(HAVE_STDINT_H)
#include <stdint.h>
#else
typedef unsigned int uint32_t;
typedef unsigned short uint16_t;
#endif
#endif

#include "packer.h"

#define ISSKIP(x) (isspace(x) || ispunct(x))

#define MINDIFF 5
#define MINLEN 6
#define MAXSTEP 4
#define MAXSTRING 200

#undef DEBUG
#undef DEBUG2

extern char *Reverse(char *buf);
extern char *Lowercase(char *buf);

static char *r_destructors[] = {
    ":",                        /* noop - must do this to test raw word. */

#ifdef DEBUG2
    (char *) 0,
#endif

    "[",                        /* trimming leading/trailing junk */
    "]",
    "[[",
    "]]",
    "[[[",
    "]]]",

    "/?p@?p",                   /* purging out punctuation/symbols/junk */
    "/?s@?s",
    "/?X@?X",

    /* attempt reverse engineering of password strings */

    "/$s$s",
    "/$s$s/0s0o",
    "/$s$s/0s0o/2s2a",
    "/$s$s/0s0o/2s2a/3s3e",
    "/$s$s/0s0o/2s2a/3s3e/5s5s",
    "/$s$s/0s0o/2s2a/3s3e/5s5s/1s1i",
    "/$s$s/0s0o/2s2a/3s3e/5s5s/1s1l",
    "/$s$s/0s0o/2s2a/3s3e/5s5s/1s1i/4s4a",
    "/$s$s/0s0o/2s2a/3s3e/5s5s/1s1i/4s4h",
    "/$s$s/0s0o/2s2a/3s3e/5s5s/1s1l/4s4a",
    "/$s$s/0s0o/2s2a/3s3e/5s5s/1s1l/4s4h",
    "/$s$s/0s0o/2s2a/3s3e/5s5s/4s4a",
    "/$s$s/0s0o/2s2a/3s3e/5s5s/4s4h",
    "/$s$s/0s0o/2s2a/3s3e/5s5s/4s4a",
    "/$s$s/0s0o/2s2a/3s3e/5s5s/4s4h",
    "/$s$s/0s0o/2s2a/3s3e/1s1i",
    "/$s$s/0s0o/2s2a/3s3e/1s1l",
    "/$s$s/0s0o/2s2a/3s3e/1s1i/4s4a",
    "/$s$s/0s0o/2s2a/3s3e/1s1i/4s4h",
    "/$s$s/0s0o/2s2a/3s3e/1s1l/4s4a",
    "/$s$s/0s0o/2s2a/3s3e/1s1l/4s4h",
    "/$s$s/0s0o/2s2a/3s3e/4s4a",
    "/$s$s/0s0o/2s2a/3s3e/4s4h",
    "/$s$s/0s0o/2s2a/3s3e/4s4a",
    "/$s$s/0s0o/2s2a/3s3e/4s4h",
    "/$s$s/0s0o/2s2a/5s5s",
    "/$s$s/0s0o/2s2a/5s5s/1s1i",
    "/$s$s/0s0o/2s2a/5s5s/1s1l",
    "/$s$s/0s0o/2s2a/5s5s/1s1i/4s4a",
    "/$s$s/0s0o/2s2a/5s5s/1s1i/4s4h",
    "/$s$s/0s0o/2s2a/5s5s/1s1l/4s4a",
    "/$s$s/0s0o/2s2a/5s5s/1s1l/4s4h",
    "/$s$s/0s0o/2s2a/5s5s/4s4a",
    "/$s$s/0s0o/2s2a/5s5s/4s4h",
    "/$s$s/0s0o/2s2a/5s5s/4s4a",
    "/$s$s/0s0o/2s2a/5s5s/4s4h",
    "/$s$s/0s0o/2s2a/1s1i",
    "/$s$s/0s0o/2s2a/1s1l",
    "/$s$s/0s0o/2s2a/1s1i/4s4a",
    "/$s$s/0s0o/2s2a/1s1i/4s4h",
    "/$s$s/0s0o/2s2a/1s1l/4s4a",
    "/$s$s/0s0o/2s2a/1s1l/4s4h",
    "/$s$s/0s0o/2s2a/4s4a",
    "/$s$s/0s0o/2s2a/4s4h",
    "/$s$s/0s0o/2s2a/4s4a",
    "/$s$s/0s0o/2s2a/4s4h",
    "/$s$s/0s0o/3s3e",
    "/$s$s/0s0o/3s3e/5s5s",
    "/$s$s/0s0o/3s3e/5s5s/1s1i",
    "/$s$s/0s0o/3s3e/5s5s/1s1l",
    "/$s$s/0s0o/3s3e/5s5s/1s1i/4s4a",
    "/$s$s/0s0o/3s3e/5s5s/1s1i/4s4h",
    "/$s$s/0s0o/3s3e/5s5s/1s1l/4s4a",
    "/$s$s/0s0o/3s3e/5s5s/1s1l/4s4h",
    "/$s$s/0s0o/3s3e/5s5s/4s4a",
    "/$s$s/0s0o/3s3e/5s5s/4s4h",
    "/$s$s/0s0o/3s3e/5s5s/4s4a",
    "/$s$s/0s0o/3s3e/5s5s/4s4h",
    "/$s$s/0s0o/3s3e/1s1i",
    "/$s$s/0s0o/3s3e/1s1l",
    "/$s$s/0s0o/3s3e/1s1i/4s4a",
    "/$s$s/0s0o/3s3e/1s1i/4s4h",
    "/$s$s/0s0o/3s3e/1s1l/4s4a",
    "/$s$s/0s0o/3s3e/1s1l/4s4h",
    "/$s$s/0s0o/3s3e/4s4a",
    "/$s$s/0s0o/3s3e/4s4h",
    "/$s$s/0s0o/3s3e/4s4a",
    "/$s$s/0s0o/3s3e/4s4h",
    "/$s$s/0s0o/5s5s",
    "/$s$s/0s0o/5s5s/1s1i",
    "/$s$s/0s0o/5s5s/1s1l",
    "/$s$s/0s0o/5s5s/1s1i/4s4a",
    "/$s$s/0s0o/5s5s/1s1i/4s4h",
    "/$s$s/0s0o/5s5s/1s1l/4s4a",
    "/$s$s/0s0o/5s5s/1s1l/4s4h",
    "/$s$s/0s0o/5s5s/4s4a",
    "/$s$s/0s0o/5s5s/4s4h",
    "/$s$s/0s0o/5s5s/4s4a",
    "/$s$s/0s0o/5s5s/4s4h",
    "/$s$s/0s0o/1s1i",
    "/$s$s/0s0o/1s1l",
    "/$s$s/0s0o/1s1i/4s4a",
    "/$s$s/0s0o/1s1i/4s4h",
    "/$s$s/0s0o/1s1l/4s4a",
    "/$s$s/0s0o/1s1l/4s4h",
    "/$s$s/0s0o/4s4a",
    "/$s$s/0s0o/4s4h",
    "/$s$s/0s0o/4s4a",
    "/$s$s/0s0o/4s4h",
    "/$s$s/2s2a",
    "/$s$s/2s2a/3s3e",
    "/$s$s/2s2a/3s3e/5s5s",
    "/$s$s/2s2a/3s3e/5s5s/1s1i",
    "/$s$s/2s2a/3s3e/5s5s/1s1l",
    "/$s$s/2s2a/3s3e/5s5s/1s1i/4s4a",
    "/$s$s/2s2a/3s3e/5s5s/1s1i/4s4h",
    "/$s$s/2s2a/3s3e/5s5s/1s1l/4s4a",
    "/$s$s/2s2a/3s3e/5s5s/1s1l/4s4h",
    "/$s$s/2s2a/3s3e/5s5s/4s4a",
    "/$s$s/2s2a/3s3e/5s5s/4s4h",
    "/$s$s/2s2a/3s3e/5s5s/4s4a",
    "/$s$s/2s2a/3s3e/5s5s/4s4h",
    "/$s$s/2s2a/3s3e/1s1i",
    "/$s$s/2s2a/3s3e/1s1l",
    "/$s$s/2s2a/3s3e/1s1i/4s4a",
    "/$s$s/2s2a/3s3e/1s1i/4s4h",
    "/$s$s/2s2a/3s3e/1s1l/4s4a",
    "/$s$s/2s2a/3s3e/1s1l/4s4h",
    "/$s$s/2s2a/3s3e/4s4a",
    "/$s$s/2s2a/3s3e/4s4h",
    "/$s$s/2s2a/3s3e/4s4a",
    "/$s$s/2s2a/3s3e/4s4h",
    "/$s$s/2s2a/5s5s",
    "/$s$s/2s2a/5s5s/1s1i",
    "/$s$s/2s2a/5s5s/1s1l",
    "/$s$s/2s2a/5s5s/1s1i/4s4a",
    "/$s$s/2s2a/5s5s/1s1i/4s4h",
    "/$s$s/2s2a/5s5s/1s1l/4s4a",
    "/$s$s/2s2a/5s5s/1s1l/4s4h",
    "/$s$s/2s2a/5s5s/4s4a",
    "/$s$s/2s2a/5s5s/4s4h",
    "/$s$s/2s2a/5s5s/4s4a",
    "/$s$s/2s2a/5s5s/4s4h",
    "/$s$s/2s2a/1s1i",
    "/$s$s/2s2a/1s1l",
    "/$s$s/2s2a/1s1i/4s4a",
    "/$s$s/2s2a/1s1i/4s4h",
    "/$s$s/2s2a/1s1l/4s4a",
    "/$s$s/2s2a/1s1l/4s4h",
    "/$s$s/2s2a/4s4a",
    "/$s$s/2s2a/4s4h",
    "/$s$s/2s2a/4s4a",
    "/$s$s/2s2a/4s4h",
    "/$s$s/3s3e",
    "/$s$s/3s3e/5s5s",
    "/$s$s/3s3e/5s5s/1s1i",
    "/$s$s/3s3e/5s5s/1s1l",
    "/$s$s/3s3e/5s5s/1s1i/4s4a",
    "/$s$s/3s3e/5s5s/1s1i/4s4h",
    "/$s$s/3s3e/5s5s/1s1l/4s4a",
    "/$s$s/3s3e/5s5s/1s1l/4s4h",
    "/$s$s/3s3e/5s5s/4s4a",
    "/$s$s/3s3e/5s5s/4s4h",
    "/$s$s/3s3e/5s5s/4s4a",
    "/$s$s/3s3e/5s5s/4s4h",
    "/$s$s/3s3e/1s1i",
    "/$s$s/3s3e/1s1l",
    "/$s$s/3s3e/1s1i/4s4a",
    "/$s$s/3s3e/1s1i/4s4h",
    "/$s$s/3s3e/1s1l/4s4a",
    "/$s$s/3s3e/1s1l/4s4h",
    "/$s$s/3s3e/4s4a",
    "/$s$s/3s3e/4s4h",
    "/$s$s/3s3e/4s4a",
    "/$s$s/3s3e/4s4h",
    "/$s$s/5s5s",
    "/$s$s/5s5s/1s1i",
    "/$s$s/5s5s/1s1l",
    "/$s$s/5s5s/1s1i/4s4a",
    "/$s$s/5s5s/1s1i/4s4h",
    "/$s$s/5s5s/1s1l/4s4a",
    "/$s$s/5s5s/1s1l/4s4h",
    "/$s$s/5s5s/4s4a",
    "/$s$s/5s5s/4s4h",
    "/$s$s/5s5s/4s4a",
    "/$s$s/5s5s/4s4h",
    "/$s$s/1s1i",
    "/$s$s/1s1l",
    "/$s$s/1s1i/4s4a",
    "/$s$s/1s1i/4s4h",
    "/$s$s/1s1l/4s4a",
    "/$s$s/1s1l/4s4h",
    "/$s$s/4s4a",
    "/$s$s/4s4h",
    "/$s$s/4s4a",
    "/$s$s/4s4h",
    "/0s0o",
    "/0s0o/2s2a",
    "/0s0o/2s2a/3s3e",
    "/0s0o/2s2a/3s3e/5s5s",
    "/0s0o/2s2a/3s3e/5s5s/1s1i",
    "/0s0o/2s2a/3s3e/5s5s/1s1l",
    "/0s0o/2s2a/3s3e/5s5s/1s1i/4s4a",
    "/0s0o/2s2a/3s3e/5s5s/1s1i/4s4h",
    "/0s0o/2s2a/3s3e/5s5s/1s1l/4s4a",
    "/0s0o/2s2a/3s3e/5s5s/1s1l/4s4h",
    "/0s0o/2s2a/3s3e/5s5s/4s4a",
    "/0s0o/2s2a/3s3e/5s5s/4s4h",
    "/0s0o/2s2a/3s3e/5s5s/4s4a",
    "/0s0o/2s2a/3s3e/5s5s/4s4h",
    "/0s0o/2s2a/3s3e/1s1i",
    "/0s0o/2s2a/3s3e/1s1l",
    "/0s0o/2s2a/3s3e/1s1i/4s4a",
    "/0s0o/2s2a/3s3e/1s1i/4s4h",
    "/0s0o/2s2a/3s3e/1s1l/4s4a",
    "/0s0o/2s2a/3s3e/1s1l/4s4h",
    "/0s0o/2s2a/3s3e/4s4a",
    "/0s0o/2s2a/3s3e/4s4h",
    "/0s0o/2s2a/3s3e/4s4a",
    "/0s0o/2s2a/3s3e/4s4h",
    "/0s0o/2s2a/5s5s",
    "/0s0o/2s2a/5s5s/1s1i",
    "/0s0o/2s2a/5s5s/1s1l",
    "/0s0o/2s2a/5s5s/1s1i/4s4a",
    "/0s0o/2s2a/5s5s/1s1i/4s4h",
    "/0s0o/2s2a/5s5s/1s1l/4s4a",
    "/0s0o/2s2a/5s5s/1s1l/4s4h",
    "/0s0o/2s2a/5s5s/4s4a",
    "/0s0o/2s2a/5s5s/4s4h",
    "/0s0o/2s2a/5s5s/4s4a",
    "/0s0o/2s2a/5s5s/4s4h",
    "/0s0o/2s2a/1s1i",
    "/0s0o/2s2a/1s1l",
    "/0s0o/2s2a/1s1i/4s4a",
    "/0s0o/2s2a/1s1i/4s4h",
    "/0s0o/2s2a/1s1l/4s4a",
    "/0s0o/2s2a/1s1l/4s4h",
    "/0s0o/2s2a/4s4a",
    "/0s0o/2s2a/4s4h",
    "/0s0o/2s2a/4s4a",
    "/0s0o/2s2a/4s4h",
    "/0s0o/3s3e",
    "/0s0o/3s3e/5s5s",
    "/0s0o/3s3e/5s5s/1s1i",
    "/0s0o/3s3e/5s5s/1s1l",
    "/0s0o/3s3e/5s5s/1s1i/4s4a",
    "/0s0o/3s3e/5s5s/1s1i/4s4h",
    "/0s0o/3s3e/5s5s/1s1l/4s4a",
    "/0s0o/3s3e/5s5s/1s1l/4s4h",
    "/0s0o/3s3e/5s5s/4s4a",
    "/0s0o/3s3e/5s5s/4s4h",
    "/0s0o/3s3e/5s5s/4s4a",
    "/0s0o/3s3e/5s5s/4s4h",
    "/0s0o/3s3e/1s1i",
    "/0s0o/3s3e/1s1l",
    "/0s0o/3s3e/1s1i/4s4a",
    "/0s0o/3s3e/1s1i/4s4h",
    "/0s0o/3s3e/1s1l/4s4a",
    "/0s0o/3s3e/1s1l/4s4h",
    "/0s0o/3s3e/4s4a",
    "/0s0o/3s3e/4s4h",
    "/0s0o/3s3e/4s4a",
    "/0s0o/3s3e/4s4h",
    "/0s0o/5s5s",
    "/0s0o/5s5s/1s1i",
    "/0s0o/5s5s/1s1l",
    "/0s0o/5s5s/1s1i/4s4a",
    "/0s0o/5s5s/1s1i/4s4h",
    "/0s0o/5s5s/1s1l/4s4a",
    "/0s0o/5s5s/1s1l/4s4h",
    "/0s0o/5s5s/4s4a",
    "/0s0o/5s5s/4s4h",
    "/0s0o/5s5s/4s4a",
    "/0s0o/5s5s/4s4h",
    "/0s0o/1s1i",
    "/0s0o/1s1l",
    "/0s0o/1s1i/4s4a",
    "/0s0o/1s1i/4s4h",
    "/0s0o/1s1l/4s4a",
    "/0s0o/1s1l/4s4h",
    "/0s0o/4s4a",
    "/0s0o/4s4h",
    "/0s0o/4s4a",
    "/0s0o/4s4h",
    "/2s2a",
    "/2s2a/3s3e",
    "/2s2a/3s3e/5s5s",
    "/2s2a/3s3e/5s5s/1s1i",
    "/2s2a/3s3e/5s5s/1s1l",
    "/2s2a/3s3e/5s5s/1s1i/4s4a",
    "/2s2a/3s3e/5s5s/1s1i/4s4h",
    "/2s2a/3s3e/5s5s/1s1l/4s4a",
    "/2s2a/3s3e/5s5s/1s1l/4s4h",
    "/2s2a/3s3e/5s5s/4s4a",
    "/2s2a/3s3e/5s5s/4s4h",
    "/2s2a/3s3e/5s5s/4s4a",
    "/2s2a/3s3e/5s5s/4s4h",
    "/2s2a/3s3e/1s1i",
    "/2s2a/3s3e/1s1l",
    "/2s2a/3s3e/1s1i/4s4a",
    "/2s2a/3s3e/1s1i/4s4h",
    "/2s2a/3s3e/1s1l/4s4a",
    "/2s2a/3s3e/1s1l/4s4h",
    "/2s2a/3s3e/4s4a",
    "/2s2a/3s3e/4s4h",
    "/2s2a/3s3e/4s4a",
    "/2s2a/3s3e/4s4h",
    "/2s2a/5s5s",
    "/2s2a/5s5s/1s1i",
    "/2s2a/5s5s/1s1l",
    "/2s2a/5s5s/1s1i/4s4a",
    "/2s2a/5s5s/1s1i/4s4h",
    "/2s2a/5s5s/1s1l/4s4a",
    "/2s2a/5s5s/1s1l/4s4h",
    "/2s2a/5s5s/4s4a",
    "/2s2a/5s5s/4s4h",
    "/2s2a/5s5s/4s4a",
    "/2s2a/5s5s/4s4h",
    "/2s2a/1s1i",
    "/2s2a/1s1l",
    "/2s2a/1s1i/4s4a",
    "/2s2a/1s1i/4s4h",
    "/2s2a/1s1l/4s4a",
    "/2s2a/1s1l/4s4h",
    "/2s2a/4s4a",
    "/2s2a/4s4h",
    "/2s2a/4s4a",
    "/2s2a/4s4h",
    "/3s3e",
    "/3s3e/5s5s",
    "/3s3e/5s5s/1s1i",
    "/3s3e/5s5s/1s1l",
    "/3s3e/5s5s/1s1i/4s4a",
    "/3s3e/5s5s/1s1i/4s4h",
    "/3s3e/5s5s/1s1l/4s4a",
    "/3s3e/5s5s/1s1l/4s4h",
    "/3s3e/5s5s/4s4a",
    "/3s3e/5s5s/4s4h",
    "/3s3e/5s5s/4s4a",
    "/3s3e/5s5s/4s4h",
    "/3s3e/1s1i",
    "/3s3e/1s1l",
    "/3s3e/1s1i/4s4a",
    "/3s3e/1s1i/4s4h",
    "/3s3e/1s1l/4s4a",
    "/3s3e/1s1l/4s4h",
    "/3s3e/4s4a",
    "/3s3e/4s4h",
    "/3s3e/4s4a",
    "/3s3e/4s4h",
    "/5s5s",
    "/5s5s/1s1i",
    "/5s5s/1s1l",
    "/5s5s/1s1i/4s4a",
    "/5s5s/1s1i/4s4h",
    "/5s5s/1s1l/4s4a",
    "/5s5s/1s1l/4s4h",
    "/5s5s/4s4a",
    "/5s5s/4s4h",
    "/5s5s/4s4a",
    "/5s5s/4s4h",
    "/1s1i",
    "/1s1l",
    "/1s1i/4s4a",
    "/1s1i/4s4h",
    "/1s1l/4s4a",
    "/1s1l/4s4h",
    "/4s4a",
    "/4s4h",
    "/4s4a",
    "/4s4h",

    /* done */
    (char *) 0
};

static char *r_constructors[] = {
    ":",

#ifdef DEBUG2
    (char *) 0,
#endif

    "r",
    "d",
    "f",
    "dr",
    "fr",
    "rf",
    (char *) 0
};

int
FascistLook(pwp, instring)
    PWDICT *pwp;
    char *instring;
{
    int i;
    char *ptr;
    char *jptr;
    char junk[STRINGSIZE];
    char ret[MAXSTRING];
    char *password;
    char rpassword[STRINGSIZE];
    uint32_t notfound;
	int res = 0x0000;

    notfound = PW_WORDS(pwp);
    /* already truncated if from FascistCheck() */
    /* but pretend it wasn't ... */
    strncpy(rpassword, instring, TRUNCSTRINGSIZE);
    rpassword[TRUNCSTRINGSIZE - 1] = '\0';
    password = rpassword;

	if (strlen(password) < MINLEN)
    {
		//strcat(res, "SHORT ");
		res = res | 0x0010; //SHORT
    }

	for (i=0;i<MAXSTRING;i++)
		ret[i]=0;

    strcpy(ret, "|");

    jptr = junk;
    *jptr = '\0';

    for (i = 0; i < STRINGSIZE && password[i]; i++)
    {
	if (!strchr(junk, password[i]))
	{
	    *(jptr++) = password[i];
	    *jptr = '\0';
	}
    }

    if (strlen(junk) < MINDIFF)
    {
		//strcat(ret, "it does not contain enough DIFFERENT characters|");
		res = res | 0x1000; // NOT DIFF
    }

    i = 0;
    ptr = password;
    while (ptr[0] && ptr[1])
    {
	if ((ptr[1] == (ptr[0] + 1)) || (ptr[1] == (ptr[0] - 1)))
	{
	    i++;
	}
	ptr++;
    }

    if (i > MAXSTEP)
    {
		//strcat(ret, "it is too simplistic/systematic|");
		res = res | 0x1000; //SIMPLISTIC
    }

    /* it should be safe to use Mangle with its reliance on STRINGSIZE
       since password cannot be longer than TRUNCSTRINGSIZE;
       nonetheless this is not an elegant solution */

    for (i = 0; r_destructors[i]; i++)
     {
	char *a;

	if (!(a = Mangle(password, r_destructors[i])))
	{
	    continue;
	}

#ifdef DEBUG
	printf("%-16s (dict)\n", a);
#endif

	if (FindPW(pwp, a) != notfound)
	{
	    //strcat(ret, "it is based on a dictionary word|");
		res = res | 0x0001; // DICTIONARY
	    return ret;
	}

    }

    strcpy(password, (char *)Reverse(password));

    for (i = 0; r_destructors[i]; i++)
     {
	char *a;

	if (!(a = Mangle(password, r_destructors[i])))
	{
	    continue;
	}
#ifdef DEBUG
	printf("%-16s (reversed dict)\n", a);
#endif
	if (FindPW(pwp, a) != notfound)
	{
	    //strcat(ret, "it is based on a (reversed) dictionary word|");
		res = res | 0x0001; // R_DICTIONARY
	    return ret;
	}
    }

    return ret;
}

const int
FascistCheck(password, path)
    const char *password;
    const char *path;
{
    PWDICT *pwp;
    char pwtrunced[STRINGSIZE];
    int res = 0x00;

    /* If passed null for the path, use a compiled-in default */
    if ( ! path )
    {
	path = DEFAULT_CRACKLIB_DICT;
    }

    /* security problem: assume we may have been given a really long
       password (buffer attack) and so truncate it to a workable size;
       try to define workable size as something from which we cannot
       extend a buffer beyond its limits in the rest of the code */

    strncpy(pwtrunced, password, TRUNCSTRINGSIZE);
    pwtrunced[TRUNCSTRINGSIZE - 1] = '\0'; /* enforce */

    /* perhaps someone should put something here to check if password
       is really long and syslog() a message denoting buffer attacks?  */

    if (!(pwp = PWOpen(path, "r")))
    {
        /* shouldn't perror in a library or exit */
	/* but should we return a "bad password" or "good password" if this error occurs */
	perror("PWOpen");
	exit(-1);
    }

    /* sure seems like we should close the database, since we're only likely to check one password */
    //strcpy(res, FascistLook(pwp, pwtrunced));
	res = FascistLook(pwp, pwtrunced);

    PWClose(pwp);
    pwp = (PWDICT *)0;

    return res;
}

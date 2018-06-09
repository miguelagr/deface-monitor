#!/usr/bin/python
# -*- coding: utf-8 -*-
#UNAM-CERT
import hashlib
import time
import psycopg2
import sys
import binascii
import socket
import requests
import urlparse
import argparse
import re
import os



def get_hosts(b1=None,b2=None,b3=None,b4=None):
    ars = locals()
    ip = ''
    for i in ars:
        if not ars[i]:
            ars[i]=range(256)
    for j in ars['b1']:
        for i in ars['b2']:
            for k in ars['b3']:
                for l in ars['b4']:
                    ip = '%s.%s.%s.%s'%(j,i,k,l)
                    yield ip


def Scan(ip,port):
    try:
        sock = socket.create_connection((ip,port),timeout=0.1)
        sock.close()
        return 1
    except Exception as e:
        return 0


def ip_gen():
    """
    Genera la base de datos con todas las IP que contengan
    el puerto 80 o 443 abierto
    Argumento:
        Nombre del archivo donde se sacan las cadenas en claro (str)
        Nombre de la tabla (str)
    Salida:
        None
    """
    ips = get_hosts(['132'],['248','247'],range(10,255))
    conn = psycopg2.connect("dbname=defmon user=mont password=hola123")
    cur = conn.cursor()
    for i in ips:
        cmd = "select ipstring from ip where ipstring like '%s';" % (i)
        cur.execute(cmd)
        ports = [Scan(i,p) for p in [80,443]]
        if cur.fetchone() is None:
            if (ports[0] == 1) or (ports[1] == 1):
                cmd = "INSERT INTO ip(ipstring,http,https) VALUES ('%s', '%s','%s');" % (i,ports[0],ports[1])
                print cmd
                cur.execute(cmd)
        else:
            cmd = "update ip set (http ,https)= ('%s','%s') where ipstring like '%s';" % (ports[0],ports[1],i)
            print cmd
            cur.execute(cmd)
        conn.commit()
    cur.close()
    conn.close()



def finder(ip):
    bing_url = 'http://www.bing.com/search?q=ip%3a'
    urls_array = []
    count = 0
    req2 = ''
    while count < 100:
        url = bing_url+ip+'&first='+str(count)
        try:
            req = requests.get(url, timeout = 3, stream = True)
	    req2 += str(req.content)
        except Exception as e:
            print e
	count = count+9
    hrefs = re.findall('href=[\'"]?([^\'" >]+)', req2)
    for href in hrefs:
        if 'http' in href:
	    if 'microsoft' not in href:
		    parse = urlparse.urlparse(href)
		    urls_array.append(parse.netloc)
#		    urls_array.append(parse.scheme+'://'+parse.netloc)
    return list(set(urls_array))




def rec_merge():
    """
    Busca el texto en claro que corresponde al hash de la entrada
    Argumentos:
        Tabla de busqueda (str)
        Cadena del digest en formato hexadecimal (str)
        Algoritmos posibles para el digest (str[])
    Salida:
        Texto en claro correspondiente al hash de entrada (str[])
    """
    conn = psycopg2.connect("dbname=defmon user=mont password=hola123")
    cur = conn.cursor()
    cmd = "select ipstring,http,https,ipid from ip  where http = '1' or https = '1';"
    cur.execute(cmd)
    al = cur.fetchone()
    while al:
        recs = []
        urls = []
        print al
        recs.append(al[0])
        recs = recs + finder(al[0])
        for i in recs:
            if al[1] == True:
                urls.append('http://%s' % i)
            if al[2] == True:
                urls.append('https://%s' % i)
        rec_gen(urls,al[3])
        print urls
        print recs

        al = cur.fetchone()

    cur.close()
    conn.close()


def rec_gen(lrecs,ipid):
    """
    Genera la base de datos con todos los hashes de cada 
    cadena de un archivo de entrada
    Argumento:
        Nombre del archivo donde se sacan las cadenas en claro (str)
        Nombre de la tabla (str)
    Salida:
        None
    """
    conn = psycopg2.connect("dbname=defmon user=mont password=hola123")
    cur = conn.cursor()
    for i in lrecs:
        cmd = "select url from recurso where url like '%s';" % (i)
        cur.execute(cmd)
        if cur.fetchone() is None:
            cmd = "INSERT INTO recurso(url,ipid) VALUES ('%s', %s);" % (i,ipid)
            print cmd
        cur.execute(cmd)
    conn.commit()
    cur.close()
    conn.close()


"""
Se debe correr primero ip_gen() y posteriormente
rec_merge(), se pueden correr imultaneamente
"""
#ip_gen()
rec_merge()

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
import datetime


dvr=['sony','camera','camara','dvr','axis','axiscommunications','panasonic','mobotix','milestone','jvc','vivotek','y-cam','qnap','arecont','iqeye','pelco','veracity','videotec','fujinon','powerdsine','securityspy']

printer=['printer','impresora','hp laserjet','canon','inkjet','black and white','scanner','xerox','samsung printer','pixma','phaser','versalink','ricoh','cartucho','tinta']

cms=['drupal','joomla','wordpress','magneto','blogger','shopify','bitrix','typo3','squerespace','prestashop']

iis=['IIS','IIS Windows Server']

itwork=['It Works','it works','It works','it Works']

def serv_gen(nombre,cms=None):
    """
    Inserta valores en la tabla de servicio
    Argumento:
        Nombre del servicio identificado (str)
        Nombre del cms identificado (str)
    Salida:
        Id del servicio (Int)
    """
    conn = psycopg2.connect("dbname=defmon user=mont password=hola123")
    cur = conn.cursor()
    if not cms:
        cmd = "select servid,nombre from servicio where nombre like '%s';" % (nombre)
        cms='NULL'
    else:
        cmd = "select servid,nombre,cms from servicio where nombre like '%s' and cms like '%s';" % (nombre,cms)
        cms="'%s'" %cms
    cur.execute(cmd)
    if cur.fetchone() is None:
        cmd2 = "INSERT INTO servicio(nombre,cms) VALUES ('%s', %s);" % (nombre,cms)
#        print cmd2
        cur.execute(cmd2)
        conn.commit()
    cur.execute(cmd)
    servid = cur.fetchone()[0]
    cur.close()
    conn.close()
    return servid

def serv_id(texto):
    """
    Identifica el tipo de servicio
    Argumentos:
        texto del recurso
    Salida:
        Id del servicio identificado (Int)
    """
    var1 = re.findall('<meta name=\"generator\" content=\".*\"',texto)
    cms2 = None
    if var1!=[]:
	cms2=var1[0].split(">")[0].split("\"")[3]
        print cms2
    for a in dvr:
	if texto.find(a) >= 0:
	    return serv_gen("dvr",cms2)
    for a in printer:
	if texto.find(a) >= 0:
	    return serv_gen("printer",cms2)
    for a in cms:
	if texto.find(a) >= 0:
	    return serv_gen("cms",cms2)
    for a in iis:
	if texto.find(a) >= 0:
	    return serv_gen("iis",cms2)
    for a in itwork:
	if texto.find(a) >= 0:
	    return serv_gen("it work",cms2)
    return serv_gen("web",cms2)


def ar_gen():
    """
    Genera la tabla con los archivos identificados
    Argumentos:
        None
    Salida:
        None
    """
    conn = psycopg2.connect("dbname=defmon user=mont password=hola123")
    cur = conn.cursor()
    cur1 = conn.cursor() 
    cur2 = conn.cursor() 
    cmd = "select recid,url from recurso;"
    cur.execute(cmd)
    al = cur.fetchone()
    while al:
        md5 = None
        print
#        print al
        try:
            req = requests.get(al[1],timeout=1,stream=True,verify=False)
            h = hashlib.new("md5")
            h.update(req.content)
            md5 = h.hexdigest()
        except Exception as e:
            sys.stderr.write("%s"%e)
#            print "ar"
        if md5:
            cmd2 = "select recid,md5 from archivo where md5 like '%s' and recid = %i;"%(md5,al[0])
            recid = al[0]
            servid = serv_id(req.content)
            print cmd2
            cur1.execute(cmd2)
            if cur1.fetchone() is None:
                arid = store(req.content,md5,'/opt/base',al[0])
                analiza_cuerpo(req.content,arid)
            recser_gen(recid,servid)
        al = cur.fetchone()
    cur1.close()
    cur.close()
    conn.close()

def store(doc,md5,uri,recid):
    """
    Almacena los archivos
    Argumentos:
        Recurso (str)[]
        md5 del recurso (str)[]
        Uri (str)[]
        Id del recurso (Int)
    """
    conn = psycopg2.connect("dbname=defmon user=mont password=hola123")
    cur = conn.cursor()
    cmd = "INSERT INTO archivo(loc,md5,gen,recid) VALUES ('%s','%s',current_timestamp(0),%s);" % ('%s'%uri,md5,recid)
    print cmd
    cur.execute(cmd)
    cmd = "select currval('archivo_arid_seq');"
    cur.execute(cmd)
    arid = cur.fetchone()[0]
    print arid
    try:
        ar = open('%s/%s'%(uri,arid),'w')
        ar.write(doc)
        ar.close()
    except Exception as e:
        print e
    conn.commit()
    cur.close()
    conn.close()
    return arid

def analiza_cuerpo(doc,arid):
    """
    Analiza el cuerpo en busca de cadenas maliciosas
    Argumentos:
        Recurso a analizar (str)[]
        Id del archivo (Int)
    Salida:
        None
    """
 
    try:
        dfmnt = re.findall('((((hacked by|hacked)|hacked-by)|hack)|owned)',doc,re.I)
        if len(dfmnt) > 0:
            conn = psycopg2.connect("dbname=defmon user=mont password=hola123")
            cur = conn.cursor()
            cmd = "INSERT INTO deteccion(arid,descripcion) VALUES ('%s','%s');" % (arid,"Defacement detectado")
            cur.execute(cmd)
            conn.commit()
            cmd2 = "select url,ipstring from archivo a, recurso r, ip i where a.recid = r.recid and i.ipid = r.ipid and a.arid = %s;"%arid
            reg = list(cur1.fetchone())
            dominio = reg[0]
            ip = reg[1]
            correo(dominio,ip,dfmnt[0],datetime.datetime.now(),"correo@correo.com","destinatario@correo.com","passwordRem")
            print "encontrado"
            cur.close()
            conn.close()

    except Exception as e:
        print 'No se encontro nada en el cuerpo de la pagina'

def recser_gen(recid,servid):
    """
    Genera la tabla transitiva entre recurso y servicio
    Argumento:
        Id del recurso (Int)
        Ide del servicio (Int)
    Salida:
        None
    """
    conn = psycopg2.connect("dbname=defmon user=mont password=hola123")
    cur = conn.cursor()
    cmd = "select * from recser where recid = %s and servid = %s;" % (recid,servid)
    cur.execute(cmd)
    if cur.fetchone() is None:
        cmd = "INSERT INTO recser(recid,servid) VALUES (%s, %s);" % (recid,servid)
        print cmd
        cur.execute(cmd)
    else:
        cmd = "update recser set (recid,servid) = (%s, %s) where recid = %s;" % (recid,servid,recid)
        print cmd
        cur.execute(cmd)
    conn.commit()
    cur.close()
    conn.close()

def correo(dominio,ip,cadena,fecha,rem,dest,psw):
	remitente = "Aline Jairo Miguel <%s>" % rem
	destinatario = "Incidentes <%s>" % dest
	asunto = "Reporte Defacement/Minning" 
	mensaje = """Hola!<br/> <br/> 
	Dominio del sitio: "%s"
	IP del sitio: "%s"
	Cadena encontrada: "%s"
	Fecha de deteccion: "%s"
	""" % (dominio,ip,cadena,fecha)
	 
	email = """From: %s 
	To: %s 
	MIME-Version: 1.0 
	Content-type: text/html 
	Subject: %s 
	 
	%s
	""" % (remitente, destinatario, asunto, mensaje) 
	try: 
		smtp = smtplib.SMTP('smtp.gmail.com',587) 
		smtp.starttls()
		smtp.login("%s" % rem ,"%s" % pwd)
		smtp.set_debuglevel(1)
		prueba = MIMEMultipart()
		prueba['Subject']=asunto
		prueba['From']=remitente
		prueba['To']=destinatario
		mensaje=MIMEText(mensaje,'html')
		prueba.attach(mensaje)
		smtp.sendmail(remitente, destinatario, prueba.as_string()) 
		smtp.quit
		print "Correo enviado" 
	except: 
		print """Error: el mensaje no pudo enviarse. 
		Compruebe que sendmail se encuentra instalado en su sistema"""


ar_gen()

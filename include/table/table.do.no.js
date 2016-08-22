// Title: Tigra Tables PRO
// URL: http://www.softcomplex.com/products/tigra_tables_pro/
// Version: 2.1
// Date: 03-09-2004 (mm-dd-yyyy)
// Notes: Registration needed to use this script legally.
//	Visit official site for details.

var TTPf=[],TTPg=[],url=d.location.href,TTPh=d.cookie.split(";");for(var i in TTPh)if(TTPh[i].indexOf("TTPro")==0){TTPg=(TTPh[i].substr(TTPh[i].indexOf("=")+1)).split(",");for(var TTPR in TTPg)TTPf[TTPR]=TTPg[TTPR].split('+');break}function TTPi(TTPj){var TTPk=[];for(var i in TTablePRO)with(TTablePRO[i])TTPk[i]=[TTPl,TTPm,TTPn,TTPo.TTPp,TTPo.TTPq,TTPT.TTPU,TTPr,TTPs].join('+');d.cookie='TTPro='+TTPk;d.location.href=url.replace("/#/","")}document.write('<SCR','IPT LANGUAGE="JavaScript" src="',path_to_files,'table.do.',window.opera?'op':'nn','.js"></SCR','IPT>');function TTPt(){var i,TTPR;if(TTPf!=''){var TTPu=TTPf[this.id];this.TTPr=TTPu[6];this.TTPs=TTPu[7]?TTPu[7]:0;if(this.TTPr)this.changeCont(this.TTPr,this.TTPs);this.TTPl=eval(TTPu[0]);this.TTPm=TTPu[1];this.TTPn=TTPu[2];this.TTPo.TTPp=eval(TTPu[3]);this.TTPo.TTPq=eval(TTPu[4]);this.TTPT.TTPU=TTPu[5]}this.TTPc=this.TTPv();this.TTPW=this.TTPc.length;if(this.TTPo.TTPp!=null)this.TTPw(-1);document.write(this.build());if(this.TTPx.join('').indexOf(5)!=-1&&this.filter)this.attachForm(document.forms['TTForm'+this.id],'filtCol','filtPatt',"filtType")}function TTPy(){TTPi(this.id)}
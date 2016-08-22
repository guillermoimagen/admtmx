// Title: Tigra Tables PRO
// URL: http://www.softcomplex.com/products/tigra_tables_pro/
// Version: 2.1
// Date: 03-09-2004 (mm-dd-yyyy)
// Notes: Registration needed to use this script legally.
//	Visit official site for details.
// ----------------------------------------------------------------------------------

var d=document,TTablePRO=[],NUM='NUM',STR='STR',DATE='DATE',CURRENCY='CURRENCY';function TCastSTR(TTPH){return TTPH.replace(/<[^>]+>/ig,'')+''}function TCastNUM(TTPH){if(isNaN(TTPH*1))return 0;else return TTPH*1}function TCastDATE(TTPH,TTP0P){if(typeof(TTPJ)!='function')return TTPH+'';if(TTP0P)return TTPJ(TTP0P,TTPH);else return TTPJ('Y-m-d',TTPH)}function TCastCURRENCY(TTPH){return TTPH.replace(/[^0-9\-\.]/g,'')*1}function TTP0Q(l,h){if(this.TTPc&&!this.TTPc.length)return true;var TTP0R=this.TTP0S[(h+l)>>1][this.TTPo.TTPp],i=l,TTPR=h,TTP0T=[];do{while(i<=h&&(this.TTP0S[i][this.TTPo.TTPp]<TTP0R))i++;while(TTPR>=l&&(TTP0R<this.TTP0S[TTPR][this.TTPo.TTPp]))TTPR--;if(i<=TTPR){TTP0T=this.TTPa[i];this.TTPa[i]=this.TTPa[TTPR];this.TTPa[TTPR]=TTP0T;TTP0T=this.TTP0S[i];this.TTP0S[i]=this.TTP0S[TTPR];this.TTP0S[TTPR]=TTP0T;i++;TTPR--}}while(i<TTPR);if(l<TTPR)this.TTP0U(l,TTPR);if(i<h)this.TTP0U(i,h)}function TTable(TTPY,TTPb,TTP0V){var TTPU=0,filters=['subcadena','igual','regexp','subcadena may/min'],i,TTP0W=['main','captCell','captText','head','foot','pagnCell','pagnText','pagnPict','filtCell','filtPatt','filtSelc'];this.TTPY=[];this.TTP0X=[];this.TTPa=[];this.TTP0Y=[],this.TTP0Z=[];this.TTP0S=[],this.TTPb=[],this.TTP0a=0;this.TTP0b=['Capt()','HdFt("head")','Body()','HdFt("foot")','Page()','Filt()'];this.id=TTablePRO.length;TTablePRO[this.id]=this;this.TTPl=null;this.TTPm='';this.TTPz='';this.TTP00='';this.TTP0c=[];this.TTP0d=[];this.TTP0L=[];this.TTPr='';this.TTPs=0;this.changeCont=TTP0e;this.buildCapt=TTP0f;this.buildHdFt=TTP0g;this.buildBody=TTPP;this.buildPage=TTP0h;this.buildFilt=TTP0i;this.build=TTP0j;this.TTP04=TTPy;this.buildCell=TTP0k;this.exeSort=TTP0l;this.TTP0U=TTP0Q;this.exePage=TTP0m;this.exeFilt=TTP0n;this.TTPv=TTP0o;this.TTPw=TTP0p;this.attachForm=TTP0q;this.TTP0r=TTPt;this.TTPe=[];this.TTP0s='';this.TTP0t=false;this.TTP0F=TTP0V.onclick;this.TTP0H=TTP0V.key||0;with(TTP0V){for(i in TTP0W)this.TTPe[TTP0W[i]]=css!=null&&css[TTP0W[i]]?' class="'+css[TTP0W[i]]+'"':'';this.TTPe.body=[];this.TTP0u=params[0]||0;this.TTP0v=params[1]||0;this.TTPX=colors||{};this.TTPx=structure;if(!paging)var paging=[];this.TTPT={'TTP1C':paging.pf||'&laquo;&laquo;','TTP1D':paging.pp||'&laquo;','TTP1F':paging.pn||'&raquo;','TTP1G':paging.pl||'&raquo;&raquo;','TTP1E':paging.tt||'&nbsp;','TTP1B':paging.sh,'TTPV':paging.by&&paging.by>0?paging.by:TTPb.length,'TTPU':0};if(!sorting)var sorting=[];this.TTPo={'s_as':sorting.as||'','s_ds':sorting.ds||'','s_no':sorting.no||'','TTPp':sorting.cl,'TTPq':sorting.or};this.btn_ok=filter.btn_ok||'filter';this.btn_no=filter.btn_no||'clear';this.TTP0w=filters;this.filter=filter.type;this.TTP0x=4;for(i=filters.length-1;i>=0;i--){if(!((1<<i)&filter.type)){this.TTP0w[i]=0;this.TTP0x--}else this.TTPn=i}if(this.filter==0)this.TTPn='';var TTP0y=freeze[0]*1,TTP0z=freeze[1]*1}this.TTP0B=TTP0V.multy_mark;this.TTPW=TTPb.length-TTP0y-TTP0z;this.TTPd=TTPY.length;for(var i in TTPY){this.TTPe.body[i]=!TTP0V.css||!TTP0V.css.body?'':typeof(TTP0V.css.body)!='object'?TTP0V.css.body:TTP0V.css.body[i]?' class="'+TTP0V.css.body[i]+'"':'';this.TTP0Y[i]={'name':TTPY[i].name.replace(/<[^>]+>/ig,'')};this.TTPY[i]={'name':TTPY[i].name,'TTP19':TTPY[i].TTP10,'type':TTPY[i].type,'TTPZ':TTPY[i].hide,'TTP13':typeof(window['TCast'+TTPY[i].type])=='function'?window['TCast'+TTPY[i].type]:typeof(TTPY[i].type)=='function'?TTPY[i].type:function(TTPH){return TTPH},'f_css':typeof(TTPY[i].format)=='function'?TTPY[i].format:function(){return null}};if(TTPY[i].hide)this.TTP0a++;if(TTPY[i].type==DATE){if(!this.TTP0t){this.TTP11=(typeof(TTPB)=='function'?TTPB:function(TTPH){return TTPH+''});this.TTP0t=true};this.TTPY[i].format_input=TTPY[i].format_input||'';this.TTPY[i].format_output=TTPY[i].format_output||''}}for(i=0;i<TTPb.length;i++)for(TTPR=0;TTPR<TTPb[0].length;TTPR++)if(TTPb[i][TTPR]+''==''||TTPb[i][TTPR]==null)TTPb[i][TTPR]='&nbsp;';for(i=0;i<TTP0y;i++)this.TTP0X[i]=TTPb[TTPU++];for(i=0;i<this.TTPW;i++){this.TTP0S[i]=[];for(var TTP12=0;TTP12<this.TTPd;TTP12++){var TTPH=TTPb[TTPU][TTP12]+'';if(this.TTPY[TTP12]['type']==DATE){this.TTP0S[i][TTP12]=this.TTPY[TTP12].TTP13(TTPH,this.TTPY[TTP12].format_input);TTPb[i][TTP12]=this.TTP11(this.TTP0S[i][TTP12],this.TTPY[TTP12].format_output)}else this.TTP0S[i][TTP12]=this.TTPY[TTP12].TTP13(TTPH)}this.TTPa[i]=TTPb[TTPU++];this.TTPb[i]=this.TTP0S[i];this.TTPa[i][this.TTPa[i].length]=i}for(i=0;i<TTP0z;i++)this.TTP0Z[i]=TTPb[TTPU++];this.TTP0r()}function TTP0e(TTPb,TTPs){var TTPU=0;if(!d.implementation&&!d.styleSheets&&!this.TTPr){this.TTPr=TTPb;this.TTPs=TTPs;TTPi(this.id);return}TTPb=window[TTPb];this.TTPb=[];this.TTP0S=[];this.TTPa=[];this.TTP0c=[];this.TTPo.TTPp=null;this.TTPc=[];this.TTPT.TTPV=TTPs&&TTPs>0?TTPs:TTPb.length;this.TTPT.TTPU=0;if(this.TTPT.TTPV>TTPb.length)this.TTPT.TTPV=TTPb.length;this.TTPW=TTPb.length-this.TTP0X.length-this.TTP0Z.length;for(i=0;i<TTPb.length;i++)for(TTPR=0;TTPR<TTPb[0].length;TTPR++)if(TTPb[i][TTPR]+''==''||TTPb[i][TTPR]==null)TTPb[i][TTPR]='&nbsp;';for(i=0;i<this.TTP0X.length;i++)this.TTP0X[i]=TTPb[TTPU++];for(i=0;i<this.TTPW;i++){this.TTP0S[i]=[];this.TTPa[i]=[];for(var TTP12=0;TTP12<this.TTPd;TTP12++){var TTPH=TTPb[TTPU][TTP12]+'';var TTP14=0;if(this.TTPY[TTP12]['type']==DATE){this.TTP0S[i][TTP12]=this.TTPY[TTP12].TTP13(TTPH,this.TTPY[TTP12].format_input);TTP14=this.TTP11(this.TTP0S[i][TTP12],this.TTPY[TTP12].format_output)}else this.TTP0S[i][TTP12]=this.TTPY[TTP12].TTP13(TTPH);this.TTPa[i][TTP12]=TTP14?TTP14:TTPb[i][TTP12]}TTPU++;this.TTPb[i]=this.TTP0S[i];this.TTPa[i][this.TTPa[i].length]=i}for(i=0;i<this.TTP0Z.length;i++)this.TTP0Z[i]=TTPb[TTPU++];if(d.implementation||d.styleSheets)this.TTP04()}function TTP0f(){var TTP08=['<tr>'],i,TTP15,TTP16,TTP17=1;for(i in this.TTPY)if(!this.TTPY[i].TTPZ)if(this.TTPY[i].type){TTP15=Boolean(this.TTPo.TTPp==i&&this.TTPo.TTPq!=1);TTP16=this.TTPo[this.TTPo.TTPp!=i?'s_no':this.TTPo.TTPq?'s_ds':'s_as'];TTP18='TTablePRO['+this.id+'].exeSort('+i+','+TTP15+')';TTP08[TTP17++]=this.buildCell(['<table cellpadding="0" cellspacing="0" border="0" width="100%"><tr valign="middle">','<td width="99%"',this.TTPe.captText,'><a title="Sort this column" href="javascript:',TTP18,'"',this.TTPe.captText,'>',this.TTPY[i].name,'</a></td><td><a href="javascript:',TTP18,'">',TTP16,'</a></td></tr></table>'].join(''),this.TTPe.captCell)}else TTP08[TTP17++]=this.buildCell(['<table cellpadding="0" width="100%" cellspacing="0" border="0"><tr valign="middle"><td width="99%"',this.TTPe.captText,'>',this.TTPY[i].name,'</td></tr></table>'].join(''),this.TTPe.captCell);TTP08[TTP17++]='</tr>';return TTP08.join('')}function TTP0i(){if(this.TTP0s)return this.TTP0s;if(this.TTP0x==0)return '';var TTP08=['<tr><td',this.TTPe.filtCell,' colspan="',this.TTPd-this.TTP0a,'" ><form id="TTForm'+this.id+'" name="TTForm'+this.id+'" onsubmit="return TTablePRO[',this.id,'].exeFilt(1);"><table border=0 cellpadding=0 cellspacing=0 width=100%><tr><td',this.TTPe.filtCell,' align=right nowrap>Buscar <input',this.TTPe.filtPatt,' type="text" name="filtPatt" size="10',this.TTPm?'" value="'+this.TTPm:'','"> como '],TTP17=13;if(this.TTP0x>1){TTP08[TTP17++]='<select'+this.TTPe.filtSelc+' name="filtType">';for(var i=0;i<this.TTP0w.length;i++)if(this.TTP0w[i])TTP08[TTP17++]=['<option value=',i,(i==this.TTPn*1?' selected':''),">",this.TTP0w[i]].join('');TTP08[TTP17++]="</select>"}else TTP08[TTP17++]=this.TTP0w[this.TTPn];TTP08[TTP17++]=' en la columna <select'+this.TTPe.filtSelc+' name="filtCol">';for(var i in this.TTPY)if(!this.TTPY[i].TTPZ&&!this.TTPY[i].TTP19)TTP08[TTP17++]='<option value='+i+(this.TTPl*1==i?' selected':'')+">"+this.TTP0Y[i].name;TTP08[TTP17++]='</select><a href="#" onclick="javascript:TTablePRO['+this.id+'].exeFilt(1)">'+this.btn_ok+'</a> <a href="#" onclick="javascript:TTablePRO['+this.id+'].exeFilt()">'+this.btn_no+'</a></td></tr></table></td></form></tr>';this.TTP0s=TTP08.join('');return this.TTP0s}function TTP0h(){var TTP1A=Math.ceil(this.TTPW/this.TTPT.TTPV)-1;if(this.TTPT.TTPV==0||(TTP1A<=0&&!this.TTPT.TTP1B))return '';var TTP08=['<tr><td align=center colspan=',this.TTPd-this.TTP0a,this.TTPe.pagnCell,'><table cellspacing="0" cellpadding="0" border="0" width="5%" align=center><tr>'],TTP17=4;this.TTPT.TTPU=this.TTPT.TTPU*1;var TTPH='<td nowrap><a'+this.TTPe.pagnPict+' href="javascript:TTablePRO['+this.id+'].exePage(';if(this.TTPT.TTPU>0){if(this.TTPT.TTP1C)TTP08[TTP17++]=TTPH+'0)" title="Primera p�gina">'+this.TTPT.TTP1C+'</a></td>';if(this.TTPT.TTP1D)TTP08[TTP17++]=TTPH+(this.TTPT.TTPU-1)+')" title="P�gina anterior">'+this.TTPT.TTP1D+'</a></td>'}TTP08[TTP17++]='<td nowrap width="99%"'+this.TTPe.pagnText+'>'+this.TTPT.TTP1E.replace('%ind',this.TTPT.TTPU+1).replace('%pgs',TTP1A+1).replace('%rcs',this.TTPW)+'</td>';if(this.TTPT.TTPU<TTP1A){if(this.TTPT.TTP1F)TTP08[TTP17++]=TTPH+(this.TTPT.TTPU+1)+')" title="P�gina siguiente">'+this.TTPT.TTP1F+'</a></td>';if(this.TTPT.TTP1G)TTP08[TTP17++]=TTPH+TTP1A+')" title="�ltima p�gina">'+this.TTPT.TTP1G+'</a></td>'}TTP08[TTP17++]='</tr></table></td></tr>';return TTP08.join('')}function TTP0k(value,TTP1H,TTP1I){return '<td'+TTP1H+(TTP1I?' '+TTP1I:'')+' valign=top>'+value+'</td>'}function TTP0g(TTP1J){var TTPH='',i,TTPR,TTP08={'head':this.TTP0X,'foot':this.TTP0Z};;for(i in TTP08[TTP1J]){TTPH+='<tr>';for(TTPR in this.TTPY)if(!this.TTPY[TTPR].TTPZ)TTPH+=this.buildCell(TTP08[TTP1J][i][TTPR],this.TTPe[TTP1J]);TTPH+='</tr>'}return TTPH}function TTP0j(){var i,TTPH="<table cellpadding="+this.TTP0u+" cellspacing="+this.TTP0v+this.TTPe.main+" width=100% border=0>";for(i in this.TTPx)TTPH+=eval('this.build'+this.TTP0b[this.TTPx[i]]);TTPH+="</table>";return TTPH}function TTP0q(TTP1K,filtCol,filtPatt,filtType){this.TTP1K=TTP1K;this.filtCol=TTP1K.elements[filtCol];this.filtPatt=TTP1K.elements[filtPatt];this.filtType=TTP1K.elements[filtType]}function TTP0n(TTP1L){if(TTP1L){if(!this.TTP1K)return false;this.TTPl=!this.filtCol?0:this.filtCol.type.indexOf('select-')>-1?this.filtCol.options[this.filtCol.selectedIndex].value:this.filtCol.value;this.TTPm=this.filtPatt.value;this.TTPn=this.filtType&&this.filtType.type.indexOf('select-')>-1?this.filtType.options[this.filtType.selectedIndex].value:this.TTPn}else{this.TTPl=null;this.TTPm=''}this.TTPT.TTPU=0;this.TTP04();return false}function TTP0m(TTPV){this.TTPT.TTPU=TTPV;this.TTP04()}function TTP0l(TTPp,TTP1M){var TTP07=this.TTPo.TTPp;this.TTPo.TTPp=TTPp;this.TTPo.TTPq=TTP1M;this.TTPT.TTPU=0;this.TTP04(true,TTP07)}function TTP0p(TTP07){var i,TTPR=0;if(TTP07==this.TTPo.TTPp){this.TTPa=this.TTPa.reverse();this.TTP0S=this.TTP0S.reverse()}else{if(!this.TTP0c[this.TTPo.TTPp]){this.TTP0U(0,this.TTP0S.length-1);this.TTP0c[this.TTPo.TTPp]=[];this.TTP0d[this.TTPo.TTPp]=[];for(i=0;i<this.TTPa.length;i++){this.TTP0c[this.TTPo.TTPp][i]=this.TTPa[i];this.TTP0d[this.TTPo.TTPp][i]=this.TTP0S[i]}this.TTP0c[this.TTPo.TTPp]['TTPq']=this.TTPo.TTPq}else{if(this.TTP0c[this.TTPo.TTPp]['TTPq']!=this.TTPo.TTPq){this.TTPa=this.TTP0c[this.TTPo.TTPp].reverse();this.TTP0S=this.TTP0d[this.TTPo.TTPp].reverse()}else{this.TTPa=this.TTP0c[this.TTPo.TTPp];this.TTP0S=this.TTP0d[this.TTPo.TTPp]}}if(this.TTPo.TTPq){this.TTPa=this.TTPa.reverse();this.TTP0S=this.TTP0S.reverse()}}}function TTP0o(){if(!this.TTPm||this.TTPl==null)return this.TTPa;var TTPa=[],TTPH;if(this.TTPn==2)var TTP1N=eval('/'+this.TTPm+'/');for(i=0;i<this.TTPa.length;i++){if(this.TTPY[this.TTPl]==DATE)TTPH=this.TTPa[i][this.TTPl]+'';else TTPH=this.TTP0S[i][this.TTPl]+'';if((this.TTPn==2&&TTPH.search(TTP1N)!=-1)||(this.TTPn==1&&TTPH==this.TTPm)||(this.TTPn==0&&TTPH.indexOf(this.TTPm)!=-1)||(this.TTPn==3&&TTPH.search(eval('/'+this.TTPm+'/i'))!=-1))TTPa[TTPa.length]=this.TTPa[i]}return TTPa}d.write('<SC','RIPT LANGUAGE="JavaScript" src="',path_to_files,'table.do.',d.implementation||d.styleSheets?'ok':'no','.js"></SCR','IPT>')
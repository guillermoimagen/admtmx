// Title: Tigra Tables PRO
// URL: http://www.softcomplex.com/products/tigra_tables_pro/
// Version: 2.1
// Date: 03-09-2004 (mm-dd-yyyy)
// Notes: Registration needed to use this script legally.
// Visit official site for details.

function TTPP(){var TTPH='',TTPQ,i,TTPR,TTPS=Math.min((this.TTPT.TTPU*1+1)*this.TTPT.TTPV,this.TTPW);for(i=this.TTPT.TTPU*this.TTPT.TTPV;i<TTPS;i++){TTPQ=this.TTPX[i%2?'odd':'even'];TTPH+="<tr"+(TTPQ?" bgcolor="+TTPQ:'')+">";for(TTPR in this.TTPY)if(!this.TTPY[TTPR].TTPZ)TTPH+=this.buildCell(this.TTPa[i][TTPR],(this.TTPY[TTPR].f_css(this.TTPb[this.TTPc[i][this.TTPd]][TTPR],this.TTPa[i][TTPR])?' class="'+this.TTPY[TTPR].f_css(this.TTPb[this.TTPc[i][this.TTPd]][TTPR],this.TTPa[i][TTPR])+'" ':this.TTPe.body[TTPR]));TTPH+="</tr>"}return TTPH}
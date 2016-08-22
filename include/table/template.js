// structure that describes columns of the table and their type
var TABLE_CAPT = [
	{
		'name' : 'name', // columns titles
		'type' : STR // standard types (STR, NUM) or custom compare function
	},
	{
		'name' : 'directory', // columns titles
		'type' : STR // standard types (STR, NUM) or custom compare function
	},
	{
		'name' : 'rate', // columns titles
		'type' : NUM // standard types (STR, NUM) or custom compare function
	},
	{
		'name' : 'size', // columns titles
		'type' : NUM // standard types (STR, NUM) or custom compare function
	}
];

// structure that describes visual aspects of the table
var TABLE_LOOK = {
	// 0 - caption,
	// 1 - header rows to be skipped at the top when applying effects,
	// 2 - body,
	// 3 - footer rows to be skipped at the bottom when applying effects,
	// 4 - paging,
	// 5 - filters
	'structure' : [0, 1, 2, 3, 4, 5],
	'params' : [3, 0], // [cellpadding,cellspacing]
	'colors' : {
		'even'    : 'white',
		'odd'     : '#E8EFF5',
		'hovered' : '#ffffcc',
		'marked'  : '#ffcc66'
	},
	'freeze' : [1, 1], // how many rows to skip [at_the_top, at_the_bottom] when applying effects
	'paging' : {
		'by' : 15, // page size (0 - no paging)
		'tt' : '&nbsp;Page %ind of %pgs&nbsp;' /* in this line you can use the following variables 1-bazed:
													%pgs total pages index
													%ind current page index
													%rcs total records found
												*/
	},
	'sorting' : {
		// HTML for ascending sorted state icon
		'as' : '<img src=img/asc.gif border=0 height=4 width=8 alt="sort descending">',
		// HTML for descending sorted state icon
		'ds' : '<img src=img/desc.gif border=0 height=4 width=8 alt="sort ascending">',
		'no' : '<img src=img/asds.gif border=0 height=9 width=8 alt="sort ascending">'
	},
	'filter' :{
		'type':0
	},
	'css' : {
		'main'     : 'tabTable',
		'body'     : ['tabBodyCol0','tabBodyCol1','tabBodyCol2','tabBodyCol3'],
		'captCell' : 'tabCaptionCell',
		'captText' : 'tabCaptionLink',
		'head'     : 'tabHeadCell',
		'foot'     : 'tabFootCell',
		'pagnCell' : 'tabPaging',
		'pagnText' : 'tabPagingText',
		'pagnPict' : 'tabPagingArrowCell',
		'filtCell' : 'tabFilter',
		'filtPatt' : 'tabFilterPattern',
		'filtSelc' : 'tabFilterSelect'
	}
};

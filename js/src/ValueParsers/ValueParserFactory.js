/**
 * @file
 * @ingroup ValueParsers
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
( function( vp, $ ) {
	'use strict';

	/**
	 * @constructor
	 * @since 0.1
	 *
	 * @param {Object} valueParsers
	 */
	var SELF = vp.ValueParserFactory = function VpValueParserFactory( valueParsers ) {
		this._parsers = {};

		for ( var parserId in valueParsers ) {
			if ( valueParsers.hasOwnProperty( parserId ) ) {
				this._parsers[parserId] = valueParsers[parserId];
			}
		}
	};

	$.extend( SELF.prototype, {
		/**
		 * @type Object
		 */
		_parsers: {},

		/**
		 * Returns the ValueParser identifiers.
		 *
		 * @since 0.1
		 *
		 * @return Array
		 */
		getParserIds: function() {
			var ids = [];

			for ( var id in this._parsers ) {
				if ( this._parsers.hasOwnProperty( id ) ) {
					ids.push( id );
				}
			}

			return ids;
		},

		/**
		 * Returns an instance of the ValueParser with the provided id or null if there is no such ValueParser.
		 *
		 * @since 0.1
		 *
		 * @param {String} parserId
		 * @param {Object} parserOptions
		 *
		 * @return vp.ValueParser|null
		 */
		newParser: function( parserId, parserOptions ) {
			if ( this._parsers[parserId] === undefined ) {
				return null;
			}

			parserOptions = parserOptions || {};

			var parser = new this._parsers[parserId]( parserOptions );

			if ( parser instanceof vp.ValueParser ) {
				return parser;
			}

			throw new Error( 'Instantiated parser does not implement vp.ValueParser interface' );
		}

	} );

}( valueParsers, jQuery ) );

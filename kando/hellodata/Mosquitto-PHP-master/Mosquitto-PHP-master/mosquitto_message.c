#ifdef HAVE_CONFIG_H
#include "config.h"
#endif

#include "php.h"
#include "php_ini.h"
#include "zend_variables.h"
#include "zend_exceptions.h"
#include "zend_API.h"
#include "ext/standard/info.h"
#include "php_mosquitto.h"

zend_class_entry *mosquitto_ce_message;
static zend_object_handlers mosquitto_message_object_handlers;
static HashTable php_mosquitto_message_properties;

/* {{{ Arginfo */

ZEND_BEGIN_ARG_INFO(Mosquitto_Message_topicMatchesSub_args, ZEND_SEND_BY_VAL)
	ZEND_ARG_INFO(0, topic)
	ZEND_ARG_INFO(0, subscription)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO(Mosquitto_Message_tokeniseTopic_args, ZEND_SEND_BY_VAL)
	ZEND_ARG_INFO(0, topic)
ZEND_END_ARG_INFO()

/* }}} */

PHP_METHOD(Mosquitto_Message, __construct)
{
	PHP_MOSQUITTO_ERROR_HANDLING();
	if (zend_parse_parameters_none() == FAILURE) {
		PHP_MOSQUITTO_RESTORE_ERRORS();
		return;
	}
	PHP_MOSQUITTO_RESTORE_ERRORS();
}

/* {{{ Mosquitto\Message::topicMatchesSub() */
PHP_METHOD(Mosquitto_Message, topicMatchesSub)
{
	char *topic = NULL, *subscription = NULL;
	int topic_len, subscription_len;
	zend_bool result;

	PHP_MOSQUITTO_ERROR_HANDLING();
	if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "ss",
				&topic, &topic_len, &subscription, &subscription_len) == FAILURE) {
		PHP_MOSQUITTO_RESTORE_ERRORS();
		return;
	}
	PHP_MOSQUITTO_RESTORE_ERRORS();

	mosquitto_topic_matches_sub(subscription, topic, (bool *) &result);
	RETURN_BOOL(result);
}
/* }}} */

/* {{{ Mosquitto\Message::tokeniseTopic() */
PHP_METHOD(Mosquitto_Message, tokeniseTopic)
{
	char *topic = NULL, **topics = NULL;
	int topic_len = 0, retval = 0, count = 0, i = 0;

	PHP_MOSQUITTO_ERROR_HANDLING();
	if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "s", &topic, &topic_len) == FAILURE) {
		PHP_MOSQUITTO_RESTORE_ERRORS();
		return;
	}
	PHP_MOSQUITTO_RESTORE_ERRORS();

	retval = mosquitto_sub_topic_tokenise(topic, &topics, &count);

	if (retval == MOSQ_ERR_NOMEM) {
		zend_throw_exception_ex(mosquitto_ce_exception, 0 TSRMLS_CC, "Failed to tokenise topic");
		return;
	}

	array_init(return_value);
	for (i = 0; i < count; i++) {
		if (topics[i] == NULL) {
			add_next_index_null(return_value);
		} else {
			add_next_index_string(return_value, topics[i], 1);
		}
	}

	mosquitto_sub_topic_tokens_free(&topics, count);
}
/* }}} */

PHP_MOSQUITTO_MESSAGE_LONG_PROPERTY_READER_FUNCTION(mid);
PHP_MOSQUITTO_MESSAGE_LONG_PROPERTY_READER_FUNCTION(qos);

static int php_mosquitto_message_read_retain(mosquitto_message_object *mosquitto_object, zval **retval TSRMLS_DC)
{
	MAKE_STD_ZVAL(*retval);
	ZVAL_BOOL(*retval, mosquitto_object->message.retain);
	return SUCCESS;
}

static int php_mosquitto_message_read_topic(mosquitto_message_object *mosquitto_object, zval **retval TSRMLS_DC)
{
	MAKE_STD_ZVAL(*retval);

	if (mosquitto_object->message.topic != NULL) {
		ZVAL_STRINGL(*retval, mosquitto_object->message.topic, strlen(mosquitto_object->message.topic), 1);
	} else {
		ZVAL_NULL(*retval);
	}

	return SUCCESS;
}

static int php_mosquitto_message_read_payload(mosquitto_message_object *mosquitto_object, zval **retval TSRMLS_DC)
{
	MAKE_STD_ZVAL(*retval);
	ZVAL_STRINGL(*retval, mosquitto_object->message.payload, mosquitto_object->message.payloadlen, 1);
	return SUCCESS;
}

PHP_MOSQUITTO_MESSAGE_LONG_PROPERTY_WRITER_FUNCTION(mid);
PHP_MOSQUITTO_MESSAGE_LONG_PROPERTY_WRITER_FUNCTION(qos);

static int php_mosquitto_message_write_retain(mosquitto_message_object *mosquitto_object, zval *newval TSRMLS_DC)
{
	zval ztmp;
	if (Z_TYPE_P(newval) != IS_BOOL) {
		ztmp = *newval;
		zval_copy_ctor(&ztmp);
		convert_to_boolean(&ztmp);
		newval = &ztmp;
	}

	mosquitto_object->message.retain = Z_LVAL_P(newval);

	if (newval == &ztmp) {
		zval_dtor(newval);
	}

	return SUCCESS;
}

static int php_mosquitto_message_write_topic(mosquitto_message_object *mosquitto_object, zval *newval TSRMLS_DC)
{
	zval ztmp;
	if (Z_TYPE_P(newval) != IS_STRING) {
		ztmp = *newval;
		zval_copy_ctor(&ztmp);
		convert_to_string(&ztmp);
		newval = &ztmp;
	}

	if (mosquitto_object->message.topic && mosquitto_object->owned_topic) {
		efree(mosquitto_object->message.topic);
	}

	mosquitto_object->message.topic = estrdup(Z_STRVAL_P(newval));
	mosquitto_object->owned_topic = 1;

	if (newval == &ztmp) {
		zval_dtor(newval);
	}

	return SUCCESS;
}

static int php_mosquitto_message_write_payload(mosquitto_message_object *mosquitto_object, zval *newval TSRMLS_DC)
{
	zval ztmp;
	if (Z_TYPE_P(newval) != IS_STRING) {
		ztmp = *newval;
		zval_copy_ctor(&ztmp);
		convert_to_string(&ztmp);
		newval = &ztmp;
	}

	if (mosquitto_object->message.payload && mosquitto_object->owned_payload) {
		efree(mosquitto_object->message.payload);
		mosquitto_object->message.payloadlen = 0;
	}

	mosquitto_object->message.payload = estrdup(Z_STRVAL_P(newval));
	mosquitto_object->message.payloadlen = Z_STRLEN_P(newval);
	mosquitto_object->owned_payload = 1;

	if (newval == &ztmp) {
		zval_dtor(newval);
	}

	return SUCCESS;
}

const php_mosquitto_prop_handler php_mosquitto_message_property_entries[] = {
	PHP_MOSQUITTO_MESSAGE_PROPERTY_ENTRY_RECORD(mid),
	PHP_MOSQUITTO_MESSAGE_PROPERTY_ENTRY_RECORD(topic),
	PHP_MOSQUITTO_MESSAGE_PROPERTY_ENTRY_RECORD(payload),
	PHP_MOSQUITTO_MESSAGE_PROPERTY_ENTRY_RECORD(qos),
	PHP_MOSQUITTO_MESSAGE_PROPERTY_ENTRY_RECORD(retain),
	{NULL, 0, NULL, NULL}
};

zval *php_mosquitto_message_read_property(zval *object, zval *member, int type ZEND_LITERAL_KEY_DC TSRMLS_DC)
{
	zval tmp_member;
	zval *retval;
	mosquitto_message_object *message_object;
	php_mosquitto_prop_handler *hnd;
	int ret;

	message_object = (mosquitto_message_object *) zend_object_store_get_object(object TSRMLS_CC);

	if (Z_TYPE_P(member) != IS_STRING) {
		tmp_member = *member;
		zval_copy_ctor(&tmp_member);
		convert_to_string(&tmp_member);
		member = &tmp_member;
	}

	ret = zend_hash_find(&php_mosquitto_message_properties, Z_STRVAL_P(member), Z_STRLEN_P(member)+1, (void **) &hnd);

	if (ret == SUCCESS && hnd->read_func) {
		ret = hnd->read_func(message_object, &retval TSRMLS_CC);
		if (ret == SUCCESS) {
			/* ensure we're creating a temporary variable */
			Z_SET_REFCOUNT_P(retval, 0);
		} else {
			retval = EG(uninitialized_zval_ptr);
		}
	} else {
		zend_object_handlers * std_hnd = zend_get_std_object_handlers();
		retval = std_hnd->read_property(object, member, type ZEND_LITERAL_KEY_CC TSRMLS_CC);
	}

	if (member == &tmp_member) {
		zval_dtor(member);
	}

	return(retval);
}

void php_mosquitto_message_write_property(zval *object, zval *member, zval *value ZEND_LITERAL_KEY_DC TSRMLS_DC)
{
	zval tmp_member;
	mosquitto_message_object *obj;
	php_mosquitto_prop_handler *hnd;
	int ret;

	if (Z_TYPE_P(member) != IS_STRING) {
		tmp_member = *member;
		zval_copy_ctor(&tmp_member);
		convert_to_string(&tmp_member);
		member = &tmp_member;
	}

	ret = FAILURE;
	obj = (mosquitto_message_object *)zend_objects_get_address(object TSRMLS_CC);

	ret = zend_hash_find(&php_mosquitto_message_properties, Z_STRVAL_P(member), Z_STRLEN_P(member) + 1, (void **) &hnd);

	if (ret == SUCCESS && hnd->write_func) {
		hnd->write_func(obj, value TSRMLS_CC);
		if (! PZVAL_IS_REF(value) && Z_REFCOUNT_P(value) == 0) {
			Z_ADDREF_P(value);
			zval_ptr_dtor(&value);
		}
	} else {
		zend_object_handlers * std_hnd = zend_get_std_object_handlers();
		std_hnd->write_property(object, member, value ZEND_LITERAL_KEY_CC TSRMLS_CC);
	}

	if (member == &tmp_member) {
		zval_dtor(member);
	}
}

static int php_mosquitto_message_has_property(zval *object, zval *member, int has_set_exists ZEND_LITERAL_KEY_DC TSRMLS_DC)
{
	php_mosquitto_prop_handler *hnd;
	int ret = 0;

	if (zend_hash_find(&php_mosquitto_message_properties, Z_STRVAL_P(member), Z_STRLEN_P(member) + 1, (void **)&hnd) == SUCCESS) {
		switch (has_set_exists) {
			case 2:
				ret = 1;
				break;
			case 0: {
				zval *value = php_mosquitto_message_read_property(object, member, BP_VAR_IS ZEND_LITERAL_KEY_CC TSRMLS_CC);
				if (value != EG(uninitialized_zval_ptr)) {
					ret = Z_TYPE_P(value) != IS_NULL? 1:0;
					/* refcount is 0 */
					Z_ADDREF_P(value);
					zval_ptr_dtor(&value);
				}
				break;
			}
			default: {
				zval *value = php_mosquitto_message_read_property(object, member, BP_VAR_IS ZEND_LITERAL_KEY_CC TSRMLS_CC);
				if (value != EG(uninitialized_zval_ptr)) {
					convert_to_boolean(value);
					ret = Z_BVAL_P(value)? 1:0;
					/* refcount is 0 */
					Z_ADDREF_P(value);
					zval_ptr_dtor(&value);
				}
				break;
			}
		}
	} else {
		zend_object_handlers * std_hnd = zend_get_std_object_handlers();
		ret = std_hnd->has_property(object, member, has_set_exists ZEND_LITERAL_KEY_CC TSRMLS_CC);
	}
	return ret;
}

static HashTable *php_mosquitto_message_get_properties(zval *object TSRMLS_DC)
{
	mosquitto_message_object *obj;
	php_mosquitto_prop_handler *hnd;
	HashTable *props;
	zval *val;
	char *key;
	uint key_len;
	HashPosition pos;
	ulong num_key;

	obj = (mosquitto_message_object *)zend_objects_get_address(object TSRMLS_CC);
	props = zend_std_get_properties(object TSRMLS_CC);

	zend_hash_internal_pointer_reset_ex(&php_mosquitto_message_properties, &pos);

	while (zend_hash_get_current_data_ex(&php_mosquitto_message_properties, (void**)&hnd, &pos) == SUCCESS) {
		zend_hash_get_current_key_ex(&php_mosquitto_message_properties, &key, &key_len, &num_key, 0, &pos);
		if (!hnd->read_func || hnd->read_func(obj, &val TSRMLS_CC) != SUCCESS) {
			val = EG(uninitialized_zval_ptr);
			Z_ADDREF_P(val);
		}
		zend_hash_update(props, key, key_len, (void *)&val, sizeof(zval *), NULL);
		zend_hash_move_forward_ex(&php_mosquitto_message_properties, &pos);
	}
	return obj->std.properties;
}


void php_mosquitto_message_add_property(HashTable *h, const char *name, size_t name_length, php_mosquitto_read_t read_func, php_mosquitto_write_t write_func TSRMLS_DC)
{
	php_mosquitto_prop_handler p;

	p.name = (char*) name;
	p.name_length = name_length;
	p.read_func = (read_func) ? read_func : NULL;
	p.write_func = (write_func) ? write_func : NULL;
	zend_hash_add(h, (char *)name, name_length + 1, &p, sizeof(php_mosquitto_prop_handler), NULL);
}

static void mosquitto_message_object_destroy(void *object TSRMLS_DC)
{
	mosquitto_message_object *message = (mosquitto_message_object *) object;
	zend_hash_destroy(message->std.properties);
	FREE_HASHTABLE(message->std.properties);

	if (message->owned_topic == 1) {
		efree(message->message.topic);
	}

	if (message->owned_payload == 1) {
		efree(message->message.payload);
	}

	efree(object);
}

static zend_object_value mosquitto_message_object_new(zend_class_entry *ce TSRMLS_DC) {

	zend_object_value retval;
	mosquitto_message_object *message_obj;
#if PHP_VERSION_ID < 50399
	zval *temp;
#endif

	message_obj = ecalloc(1, sizeof(mosquitto_message_object));
	message_obj->std.ce = ce;

#ifdef ZTS
	message_obj->TSRMLS_C = TSRMLS_C;
#endif

	ALLOC_HASHTABLE(message_obj->std.properties);
	zend_hash_init(message_obj->std.properties, 0, NULL, ZVAL_PTR_DTOR, 0);
#if PHP_VERSION_ID < 50399
	zend_hash_copy(message_obj->std.properties, &mosquitto_ce_message->default_properties, (copy_ctor_func_t) zval_add_ref,(void *) &temp, sizeof(zval *));
#else
	object_properties_init(&message_obj->std, mosquitto_ce_message);
#endif
	retval.handle = zend_objects_store_put(message_obj, NULL, (zend_objects_free_object_storage_t) mosquitto_message_object_destroy, NULL TSRMLS_CC);
	retval.handlers = &mosquitto_message_object_handlers;
	return retval;
}

const zend_function_entry mosquitto_message_methods[] = {
	PHP_ME(Mosquitto_Message, __construct, NULL, ZEND_ACC_PUBLIC|ZEND_ACC_CTOR)
	PHP_ME(Mosquitto_Message, topicMatchesSub, Mosquitto_Message_topicMatchesSub_args, ZEND_ACC_PUBLIC|ZEND_ACC_STATIC)
	PHP_ME(Mosquitto_Message, tokeniseTopic, Mosquitto_Message_tokeniseTopic_args, ZEND_ACC_PUBLIC|ZEND_ACC_STATIC)
	PHP_FE_END
};

PHP_MINIT_FUNCTION(mosquitto_message)
{
	zend_class_entry message_ce;
	memcpy(&mosquitto_message_object_handlers, zend_get_std_object_handlers(), sizeof(zend_object_handlers));
	mosquitto_message_object_handlers.read_property = php_mosquitto_message_read_property;
	mosquitto_message_object_handlers.write_property = php_mosquitto_message_write_property;
	mosquitto_message_object_handlers.has_property = php_mosquitto_message_has_property;
	mosquitto_message_object_handlers.get_properties = php_mosquitto_message_get_properties;

	INIT_NS_CLASS_ENTRY(message_ce, "Mosquitto", "Message", mosquitto_message_methods);
	mosquitto_ce_message = zend_register_internal_class(&message_ce TSRMLS_CC);
	mosquitto_ce_message->create_object = mosquitto_message_object_new;

	zend_hash_init(&php_mosquitto_message_properties, 0, NULL, NULL, 1);
	PHP_MOSQUITTO_ADD_PROPERTIES(&php_mosquitto_message_properties, php_mosquitto_message_property_entries);

	return SUCCESS;
}	

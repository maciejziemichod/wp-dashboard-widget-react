import styles from './ErrorMessage.module.css';

type ErrorMessageProps = {
	message: string;
};

export function ErrorMessage({ message }: ErrorMessageProps) {
	return <p className={styles.message}>{message}</p>;
}
